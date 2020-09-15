<?php


namespace Controllers;

use PDO;
use Lib\Request;
use Lib\Response;

class AzsController
{
    public PDO $db;
    public Response $response;
    public array $data;
    // массив разрешенный ключей для запроса
    public array  $keys = [
        'number_azs',
        'city_azs',
        'street_azs',
        'region_azs'
    ];

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->data = (new Request)->dataFetch();
        $this->response = new Response();
    }

    /**
     * выборка данных для формы
     */
    public function getFormData()
    {

        $sql = "SELECT ".$this->data['name']." FROM address WHERE 1=1";
        $values = [];
        $where = '';

        foreach ($this->data['selected'] as $key => $value) {
            if ($value && in_array($key, $this->keys)) {
                if ($key == $this->data['name']) {
                    $where .= " AND $key LIKE ?";
                    $values[] = "%$value%";
                } else {
                    $where .= " AND $key=?";
                    $values[] = $value;
                }
            }
        }

        $sql .= "$where group by ".$this->data['name']." LIMIT 20";

        $stmt = $this->db->prepare($sql);
        $stmt = $this->bindValues($stmt, $values);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $countRow = count($result);

        // проверка на наличие всего одной строки с несгруппированными данными
        if (count($result) == 1) {
            $resultCheckOne = $this->checkOneRow($where, $values);
            if (count($resultCheckOne) == 1) {
                $result = $resultCheckOne;
            }
            $countRow = count($resultCheckOne);
        }

        $this->response->toJson([
            'data' => $result,
            'count' => $countRow,
        ]);
    }

    /**
     * Выборка с несгруппированными данными
     * @param string $where
     * @param array $values
     * @return array
    */
    protected function checkOneRow(string $where, array $values): array
    {
        $sql = "SELECT number_azs, city_azs, street_azs, region_azs FROM address WHERE 1=1 $where LIMIT 20";
        $stmt = $this->db->prepare($sql);
        $stmt = $this->bindValues($stmt, $values);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function bindValues($stmt, array $values)
    {
        $end = count($values);
        for ($i = 0; $i < $end; $i++) {
            $stmt->bindValue($i + 1, $values[$i]);
        }

        return $stmt;
    }
}
