# Тестовое задание
- Необходимо реализовать интеграцию к предлагаемому api
- Написать к нему unit тесты не используя фреймворк.
- Все запросы к интеграции необходимо производить при помощи Guzzle (http://docs.guzzlephp.org/en/stable/) .
- Результат работы выложить на github.


## Легенда
Надо написать интеграцию к http://testapi.ru, который позволяет запросить данные пользователя и обновить их в сторонней системе.
Изначально мы запрашиваем данные пользователя, затем мы изменяем у него некоторые учетные данные (имя и флаг блокировки, его права)
и отправляем результат в интегрируемую систему.

### 1. Авторизация
Для работы с api необходимо изначально произвести авторизацию по адресу http://testapi.ru/auth
* метод GET
* параметры login и pass
* где login=test, pass=12345

результатом будет json в котором будет содержаться token ответ:
```
{
    "status": "OK",
    "token": "dsfd79843r32d1d3dx23d32d"
}
```

### 2. Получение данных пользователя
Так же api предоставляет возможность получения данные пользователя по адресу http://testapi.ru/get-user/?token=

* метод GET
* username = ivanov
* token = токен полученный при авторизации

результатом будет json в котором будет содержать данные пользователя ответ:
```
{
    "status": "OK",
    "active": "1",
    "blocked": false,
    "created_at": 1587457590,
    "id": 23,
    "name": "Ivanov Ivan",
    "permissions": [
        {
            "id": 1,
            "permission": "comment"
        },
        {
            "id": 2,
            "permission": "upload photo"
        },
        {
            "id": 3,
            "permission": "add event"
        }
    ]
}
```

### 3. Отправка данных пользователя
И api предоставляет возможность обновить данные пользователя по адресу http://testapi.ru/user//update?token=

* метод POST
* тело запроса
```
{
  "active": "1",
  "blocked": true,
  "name": "Petr Petrovich",
  "permissions": [
    {
      "id": 1,
      "permission": "comment"
    },
  ]
}
```
Ответ:
```
{
    "status": "OK",
}
```
### 4. Дополнение
Для каждого запроса Помимо стандартных HTTP кодов ответа есть еще дополнительный параметр "status" который сигнализирует нам об успешности операции:

```
* OK - успешно
* Not found - пользователь не найден
* Error - ошибка
```