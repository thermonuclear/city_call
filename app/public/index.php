<?php
require_once '../vendor/autoload.php';

use Controllers\AzsController;
use Db\Database;

$db = (new Database)->getDbConnection();

// получение данных для веб-формы
if ($_SERVER['REQUEST_URI'] == '/webform') {
    (new AzsController($db))->getFormData();
} else {
    echo 'index.php :)<br>';
    echo 'rest api для списка товаров доступно city-call.test/api/products<br>';
    echo 'веб форма доступна по адресу http://city-call.test/webform.html';
}

