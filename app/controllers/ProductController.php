<?php

namespace Controllers;

use Lib\Request;
use PDO;
use Lib\Response;

/**
 * Обработка запросов по товарам
*/
class ProductController
{
    public PDO $db;
    public array $data;
    public Request $request;
    public Response $response;

    public function __construct(PDO $db, Request $request)
    {
        $this->db = $db;
        $this->data = $request->data();
        $this->response = new Response();
        $this->request = $request;
    }

    /**
     * вывод товара
    */
    public function show()
    {
        $sql = "SELECT name, price, description, weight, article FROM products";

        if (isset($this->request->resource[1])) {
            $sql .= ' WHERE id=' . (int)$this->request->resource[1];
        }
        $result = ($this->db->query($sql))->fetchAll(PDO::FETCH_ASSOC);

        $this->response->toJson(['data' => $result]);
    }

    /**
     * создание товара
     */
    public function store()
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, description, weight, article) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $this->data['name']);
        $stmt->bindValue(2, $this->data['price']);
        $stmt->bindValue(3, $this->data['description']);
        $stmt->bindValue(4, $this->data['weight']);
        $stmt->bindValue(5, $this->data['article']);

        if ($stmt->execute()) {
            $this->response->toJson(['success'=> 1]);
        } else {
            $this->response->toJson(['error'=> 'ошибка создания товара']);
        }
    }

    /**
     * обновление товара
     */
    public function update()
    {
        $stmt = $this->db->prepare("UPDATE products SET name=?, price=?, description=?, weight=?, article=? WHERE id=?");
        $stmt->bindValue(1, $this->data['name']);
        $stmt->bindValue(2, $this->data['price']);
        $stmt->bindValue(3, $this->data['description']);
        $stmt->bindValue(4, $this->data['weight']);
        $stmt->bindValue(5, $this->data['article']);
        $stmt->bindValue(6, (int)$this->request->resource[1]);

        if ($stmt->execute()) {
            $this->response->toJson(['success'=> 1]);
        } else {
            $this->response->toJson(['error'=> 'ошибка обновления товара']);
        }
    }

    /**
     * удаление товара
     */
    public function destroy()
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id=?");
        $stmt->bindValue(1, (int)$this->request->resource[1]);

        if ($stmt->execute()) {
            $this->response->toJson(['success'=> 1]);
        } else {
            $this->response->toJson(['error'=> 'ошибка удаления товара']);
        }
    }
}
