# city-call.test
тестовое задание.
версия php 7.4.*
Настроена среда разработки на докер, папка docker_cc
поднятие докер в папке docker_cc: docker-compose up -d
автозагрузчик в папке app в контейнере php-fpm (docker-compose exec php-fpm /bin/bash) выполнить: composer install
для работы нужно в базу app подгрузить данные из sql.zip
phpadmin после поднятия докера доступен по http://localhost:8080/
mysql: user app pass app либо user root pass root
на локалке в hosts добавить: 127.0.0.1 city-call.test 
# задача 1
ответ в файле answer.sql
# задача 2
rest api для списка товаров доступно city-call.test/api/products
таблица с товарами: products.
для создания и заполнения таблицы товаров достаточно выполнить любой запрос:
список товаров get city-call.test/api/products
товар get city-call.test/api/products/id
создание post city-call.test/api/product
обновление put city-call.test/api/product/id
удаление delete city-call.test/api/product/id
# задача 3
веб форма доступна по адресу http://city-call.test/webform.html
