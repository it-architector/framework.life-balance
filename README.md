# Framework Life Balance

![ядро: v1.2.4](https://img.shields.io/badge/Ядро-v1.2.4-blue.svg) ![интерфейс: v1.1.4](https://img.shields.io/badge/Интерфейс-v1.1.4-blue.svg)

### Среда

Среда сопровождает два направления разработки сайта: ядро (back-end) и интерфейс (front-end).

Ядро и интерфейс разделены и изолированы, что позволяет безпрепятственно разрабатывать оба направления одновременно, почтительно дополняя (без возникновения каких либо merge) на git'e. 
 
![Framework](/Компоненты%20интерфейса/3.Распределение/Элементы/Элементы%20картинок/slider/slide1_bg.jpg)

Состав среды:

| № | Компоненты ядра | Компоненты интерфейса
 ------------- |  ------------- | ------------- | 
| 1. | Условия: цели, сведения, требования | Условия: цели, сведения, требования
| 2. | Пространство: структуры | Пространство: структуры
| 3. | Распределение: элементы | Распределение: элементы
| 4. | Реализация: функции | Реализация: функции
| 5. | Модули | Модули

![hr](/Компоненты%20интерфейса/3.Распределение/Элементы/Элементы%20картинок/illustrators/hr.png)


### Ядро

В ядре реализованы <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/">Требования</a> (детализация) ядра, наглядность <a target="_blank" href="/Компоненты ядра/2.Пространство/Структуры/">Структуры</a> (планировка), <a target="_blank" href="/Компоненты ядра/4.Реализация/Функции/Функции компонентов/">Функции 4-х компонентов</a> (распределенная альтернатива контролёров в mvc), <a target="_blank" href="/Компоненты ядра/4.Реализация/Функции/Функции категорий сайта/">Функции категорий сайта</a> (упрощённая альтернатива моделей в mvc) и <a target="_blank" href="/Компоненты ядра/3.Распределение/Элементы/2.Элементы базы данных.php">Элементы базы данных</a> (упрощённая альтернатива yii2 migrate, установки и настроек). Благодаря такому подходу была реализована <a target="_blank" href="/Компоненты ядра/2.Пространство/Структуры/3.Структура таблиц базы данных.php">Структура таблиц базы данных</a> и функция автоматической реконструкции базы данных, что освободило разработчиков от необходимости конструировать sql-запросы вручную. А так же реализован внутренний самовызов из консоли, оттого на фоновый режим отработки была переведена отправка почтового сообщения и реструктуризация базы данных, что для пользователя значительно уменьшило время ожидания ответа, а у разработчиков отпала необходимость настраивать cron.

Требования:

> Под требованиями понимается образец, эталон, модель.

- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/1.Требования к серверу.md">Требования к серверу</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/2.Требования к языкам программирования ядра.md">Требования к языкам программирования ядра</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/3.Требования к компонентам ядра.md">Требования к компонентам ядра</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/4.Требования к разработчикам ядра.md">Требования к разработчикам ядра</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/5.Требования к разработке ядра.md">Требования к разработке ядра</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/1.Требования к структурам/1.Требования к структурам запросов.md">Требования к структурам запросов</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/1.Требования к структурам/2.Требования к структурам базы данных.md">Требования к структурам базы данных</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/2.Требования к объёмам/1.Требования к объёмам взаимодействия с базой данных.md">Требования к объёмам взаимодействия с базой данных</a>
- <a target="_blank" href="/Компоненты ядра/1.Условия/3.Требования/3.Требования к функциям/1.Требования к функциям запросов.md">Требования к функциям запросов</a>


Структуры:

> Под структурами понимается места для внутреннего обустройства.

- <a target="_blank" href="/Компоненты ядра/2.Пространство/Структуры/1.Структура внутренних путей.php">Структура внутренних путей</a>
- <a target="_blank" href="/Компоненты ядра/2.Пространство/Структуры/2.Структура функций компонентов.md">Структура функций компонентов</a>
- <a target="_blank" href="/Компоненты ядра/2.Пространство/Структуры/3.Структура таблиц базы данных.php">Структура таблиц базы данных</a>
- <a target="_blank" href="/Компоненты ядра/2.Пространство/Структуры/4.Структура функций сайта.php">Структура функций сайта</a>

Элементы:

> Под элементами понимается мера объединения.

- <a target="_blank" href="/Компоненты ядра/3.Распределение/Элементы/1.Элементы функций компонентов.php">Элементы функций компонентов</a>
- <a target="_blank" href="/Компоненты ядра/3.Распределение/Элементы/2.Элементы базы данных.php">Элементы базы данных</a>
- <a target="_blank" href="/Компоненты ядра/3.Распределение/Элементы/3.Элементы функций сайта.php">Элементы функций сайта</a>

Функции:

> Под функциями понимается готовые алгоритмы.

- <a target="_blank" href="/Компоненты ядра/4.Реализация/Функции/Функции компонентов/">Функции компонентов</a>
- <a target="_blank" href="/Компоненты ядра/4.Реализация/Функции/Функции категорий сайта/">Функции категорий сайта</a>


![hr](/Компоненты%20интерфейса/3.Распределение/Элементы/Элементы%20картинок/illustrators/hr.png)

### Интерфейс

В интерфейсе реализована структура landing-page + ajax подгрузка данных с ядра по api, что позволяет пользователю взаимодействовать с сайтом без прерываний, а разработчику интерфейса иметь исходники без каких либо php-вставок.

Требования:

> Под требованиями понимается образец, эталон, модель.

- <a target="_blank" href="/Компоненты интерфейса/1.Условия/3.Требования/1.Требования к браузеру.md">Требования к браузеру</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Условия/3.Требования/2.Требования к языкам программирования интерфейса.md">Требования к языкам программирования интерфейса</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Условия/3.Требования/3.Требования к компонентам интерфейса.md">Требования к компонентам интерфейса</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Условия/3.Требования/4.Требования к разработчикам интерфейса.md">Требования к разработчикам интерфейса</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Условия/3.Требования/5.Требования к разработке интерфейса.md">Требования к разработке интерфейса</a>


Структуры:

> Под структурами понимается места для внутреннего обустройства.

- <a target="_blank" href="/Компоненты интерфейса/2.Пространство/Структуры/Структура сайта/Исходник сайта.zip">Исходник сайта</a>
- <a target="_blank" href="/Компоненты интерфейса/2.Пространство/Структуры/Структура функций/Структура функций категорий сайта.md">Структура функций категорий сайта</a>
- <a target="_blank" href="/Компоненты интерфейса/2.Пространство/Структуры/Структура функций/Структура функций компонентов.md">Структура функций компонентов</a>


Элементы:

> Под элементами понимается мера объединения.

- <a target="_blank" href="/Компоненты интерфейса/3.Распределение/Элементы/Элементы тэгов/">Элементы тэгов</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Распределение/Элементы/Элементы функций/Элементы функций всех категорий.js">Элементы функций всех категорий</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Распределение/Элементы/Элементы стилей/">Элементы стилей</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Распределение/Элементы/Элементы%20картинок/">Элементы картинок</a>

Функции:

> Под функциями понимается готовые алгоритмы.

- <a target="_blank" href="/Компоненты интерфейса/4.Реализация/Функции/Функции компонентов/">Функции компонентов</a>
- <a target="_blank" href="/Компоненты интерфейса/4.Реализация/Функции/Функции категорий сайта/">Функции категорий сайта</a>


![hr](/Компоненты%20интерфейса/3.Распределение/Элементы/Элементы%20картинок/illustrators/hr.png)

### Порядок

Порядок разработки выстроен так, что равномерно переводит команду разработчиков на форму управления "холакратия", которая эффективна в непрерывной и распределительной разработке web-сайтов. При этом изучать холакратию не нужно, достаточно каждому участнику разработки соответствовать требованиям.

> Холакратия — это способ децентрализации власти, который позволяет выстроить иерархию (холархию) таким образом, чтобы каждый сотрудник мог влиять на жизнь компании и обладал полной властью в рамках своей роли и возложенных на неё обязательств.


![Холакратия](/Компоненты%20интерфейса/3.Распределение/Элементы/Элементы%20картинок/illustrators/4values.jpg)

### Примечание

p.s.1. Исходный код сайта https://framework-life-balance.ru подгружается с репозитория <a target="_blank" href="https://github.com/it-architector/project-concern.csdr">project-concern.csdr</a>.

p.s.2. Как framework данная среда не подойдёт. Смотрите <a target="_blank" href="https://github.com/it-architector/release.csdr">release.csdr</a>.

p.s.3. О CSDR (парадигме выстраивания проекта) смотрите здесь <a target="_blank" href="https://github.com/it-architector/easy-oop.csdr">easy-oop.csdr</a>.
