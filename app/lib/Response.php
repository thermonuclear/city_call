<?php


namespace Lib;


class Response
{
    public function toJson(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
