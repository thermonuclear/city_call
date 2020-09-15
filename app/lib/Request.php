<?php
namespace Lib;

/**
 * Обработчик запроса
*/
class Request
{
    public string $method;
    public array $resource;

    public function __construct()
    {
        // Определяем метод запроса
        $this->method = $_SERVER['REQUEST_METHOD'];

        // хак для форм
        if ($this->method === 'POST' &&  isset($_POST['_method']) && in_array($_POST['_method'], ['PUT', 'DELETE'])) {
            $this->method = $_POST['_method'];
        }

        // Определяем запрашиваемый ресурс
        $resource = preg_split('#/#', trim($_SERVER['REQUEST_URI'], '/'));
        // убираем первый элемент, т.к. адреса апи будут начинаться с api/
        array_shift($resource);
        $this->resource = $resource;
    }

    /**
     * Данные из запроса
     * @return array
     */
    public function data()
    {
        // GET или POST: данные возвращаем как есть
        if ($this->method === 'GET') {
            return $_GET;
        }
        if ($this->method === 'POST' || (isset($_POST['_method']) && in_array($_POST['_method'], ['PUT', 'DELETE']))) {
            return $_POST;
        }

        // PUT, DELETE
        $data = [];
        $exploded = explode('&', file_get_contents('php://input'));

        foreach ($exploded as $pair) {
            $item = explode('=', $pair);
            if (count($item) == 2) {
                $data[urldecode($item[0])] = urldecode($item[1]);
            }
        }

        return $data;
    }

    public function dataFetch() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        return $data;
    }

    /**
     * метод http запроса
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * запрашиваемый ресурс
     * @return array
     */
    public function resource(): array
    {
        return $this->resource;
    }
}
