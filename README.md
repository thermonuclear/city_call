## city-call.test
тестовое задание.<br>
версия php 7.4.* <br>
Настроена среда разработки на докер, папка docker_cc<br>
поднятие докер в папке docker_cc: docker-compose up -d<br>
автозагрузчик в папке app в контейнере php-fpm (docker-compose exec php-fpm /bin/bash) выполнить: composer install<br>
для работы нужно в базу app подгрузить данные из sql.zip<br>
phpmyadmin после поднятия докера доступен по http://localhost:8080/ <br>
mysql: user app pass app либо user root pass root<br>
на локалке в hosts добавить: 127.0.0.1 city-call.test<br> 
### задача 1
ответ в файле answer.sql
### задача 2
rest api для списка товаров доступно city-call.test/api/products<br>
таблица с товарами: products.<br>
для создания и заполнения таблицы товаров достаточно выполнить любой запрос:<br>
список товаров get city-call.test/api/products<br>
товар get city-call.test/api/products/id<br>
создание post city-call.test/api/product<br>
обновление put city-call.test/api/product/id<br>
удаление delete city-call.test/api/product/id<br>
### задача 3
веб форма доступна по адресу http://city-call.test/webform.html
