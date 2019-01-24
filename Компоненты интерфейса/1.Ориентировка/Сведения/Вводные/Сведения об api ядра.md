## Сведения об api ядра

На запрос вида:
`/Ядро.php?request=/users/authorized_data`

> Возможно добавление на конце запроса параметров, пример: `/Ядро.php?request=/users/index&page=2`

Ответ приходит в виде json:
`{"responding":"\/users\/authorized_data","title":"","description":"","keywords":"","content":{"user_data":{"id":"1","nickname":"\u0412\u0440\u0435\u043c\u044f","password":"1ad2fe289fe5d68244efeb948b4c25f1","name":"\u0411\u0435\u043b\u043e\u044f\u0440\u044a","family_name":"\u0427\u0430\u0439\u043a\u0430","email":"az.lubov8@gmail.com","is_admin":"true","session":"6266773174685953fb90ef858d106e66"}}}`

Где,

1. Отвечающий: responding
2. Заголовок страницы: title
2. Описание страницы: description
2. Ключевики страницы: keywords
2. Массив контекста: content

При ошибке ядра может прийти ответ в виде текста:
`Не найден файл настроек системы`

Схема функций сайта находится по адресу: `/Компоненты ядра/3.Ресурсы/Схемы/Схема функций сайта.php`