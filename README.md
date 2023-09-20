# smartylab-test-task
###### Laravel v8.83.27 (PHP v8.1.0) 

## REST API:
### Laravel Passport
**Token TTL - 24h**

Пример запроса
```
POST /api/auth/register HTTP/1.1
Host: localhost:8000
Content-Type: application/json
{
    "name": "Test",
    "email": "Test@gmail.com",
    "password": "qwerty"
}
```
<br>
**POST /api/auth/register** - register
```
{
    "name": string,
    "email": string|email,
    "password":  string|min:6
}
```
Пример ответа
```
{
    "token": string
}
```
**POST /api/auth/login** - login
```
{
    "email": string,
    "password":  string
}
```
Пример ответа
```
{
    "token": string
}
```
<br><br>
### Tasks
Пример запроса
```
POST /api/tasks/ HTTP/1.1
Host: localhost:8000
Content-Type: application/json
Authorization: Bearer {token}

{
    "title": "Some task",
    "description": "Some task",
    "endDate": "2023-05-21",
    "completed": false
}
```
**GET /api/tasks** - index
параметры
```
completed=boolean
endDate=date(Y-m-d)
sort=asc||desc
```
Примеры запросов
```
http://localhost:8000/api/tasks?completed=true&sort=asc
http://localhost:8000/api/tasks/?endDate=2023-09-23
```
Пример ответа
```
{
    "data": [
        {
            "id": int,
            "title": string,
            "description": string,
            "endDate": string,
            "completed": boolean
        },
		...
	]
}
```
**GET /api/tasks/{id}**  - show<br>
Пример ответа
```
{
    "data": {
            "id": int,
            "title": string,
            "description": string,
            "endDate": string,
            "completed": boolean
	}
}
```
**POST /api/tasks** - store
```
{
    "title": string:required,
    "description": string:required,
    "endDate": string(Y-m-d):required,
    "completed": boolean
}
```
Пример запроса
```
{
    "title": "Some task",
    "description": "Some task",
    "endDate": "2023-05-21",
    "completed": false
}
```
Пример ответа
```
{
    "data": {
            "id": int,
            "title": string,
            "description": string,
            "endDate": string,
            "completed": boolean
	}
}
```
**PUT /api/tasks/{id}** - update
```
{
    "title": string:required,
    "description": string:required,
    "endDate": string(Y-m-d):required,
    "completed": boolean
}
```
Пример запроса
```
{
    "title": "Updated some task",
    "description": "Updated some task",
    "endDate": "2023-09-02",
    "completed": true
}
```
Пример ответа
```
{
    "data": {
            "id": int,
            "title": string,
            "description": string,
            "endDate": string,
            "completed": boolean
	}
}
```
**DELETE /api/tasks/{id}** - destroy<br>
Пример ответа
```
{
    "message": "Task has been deleted"
}
```

## Установка

- Загрузите репозиторий с помощью команды ```git clone https://github.com/AndrewYaremenko/smartylab-test-task.git```
- Перейдите в директорию проекта
- Установите необходимые PHP библиотеки, выполнив команду: ```composer install```
- Скопируйте файл ```.env.example``` и переименуйте его в ```.env```, затем откройте файл и укажите следующие поля
<pre>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
</pre>
- Сгенерируйте ключ приложения, выполнив команду: ```php artisan key:generate```
- Выполните миграцию таблиц в БД с помощью команды: ```php artisan migrate```
- Установите laravel passport: ```php artisan passport:install```
- Загрузите готовые данные в таблицы, используя команду: ```php artisan db:seed```
- Запустить сервер: ```php artisan serve```