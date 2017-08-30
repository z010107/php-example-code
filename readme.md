# Гемотест (тестовое задание)

## Установка

- Склонировать проект в папку на сервере
```
git clone git@github.com:z010107/gemotest.git .
```
- Подключить все зависимости.
```
composer install
```
- Скопировать файл .evn.example в .env, запустить php artisan key:generate и изменить параметры доступа к БД
```
APP_ENV=production
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=http://[ваш домен]

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```
- Запустить миграции php artisan migrate
- Пользоваться

Для настройки веб сервера см. [https://laravel.com/docs/5.3/installation#web-server-configuration]

Docroot - [папка клона проекта]/public
