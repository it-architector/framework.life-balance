# Framework life balance 

![ядро: v1.1.8.18](https://img.shields.io/badge/Ядро-v1.1.8.18-blue.svg) ![интерфейс: v1.0.7.20](https://img.shields.io/badge/Интерфейс-v1.0.7.20-blue.svg)

Framework life balance предназначен для **сопровождения** всех этапов разработки отеческого сайта с любым масштабом на исходном php-коде, html-разметках ( css, image ) и js-скриптах, с применением чёткой последовательностью разработки (смотрите <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/5.Стандарт разработки.md">стандарт разработки ядра</a> и <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/5.Стандарт разработки.md">стандарт разработки интерфейса</a>) 10 компонентов сайта:

| № | Компоненты ядра | Компоненты интерфейса
 ------------- |  ------------- | ------------- | 
| 1. | Ориентировка: цели, сведения, стандарты | Ориентировка: цели, сведения, стандарты
| 2. | Представление: структуры | Представление: дизайн, картинки
| 3. | Аккумуляция: нормативы | Аккумуляция: нормативы
| 4. | Движение: протоколы, функции | Движение: протоколы, функции
| 5. | Модули | Модули

<a target="_blank" href="https://framework-life-balance.ru/#about">Подробнее о проекте</a> (в том числе про этапы развёртки).


<hr>

### Среда

У Framework life balance две среды разработки: back-end (ядро) и front-end (интерфейс). Здесь нет места для php-кода в интерфейсе, и html-а в ядре. Ядро и интерфейс разделены и изолированы, что позволяет безпрепятственно разрабатывать оба направления одновременно, почтительно дополняя (без возникновения каких либо merge) на git'e.

![Framework life balance](https://framework-life-balance.ru/Компоненты%20интерфейса/2.Представление/Картинки/slider/slide1_bg.jpg)

<hr>

### Ядро

В ядре реализованы Стандарты (детализации) ядра, наглядность Структуры (планировка), 4-е Сути (распределенная альтернатива контролёров в mvc), Функции (упрощённая альтернатива моделей в mvc) и Нормативы (упрощённая альтернатива yii2 migrate, установки и настроек). Благодаря такому подходу был реализован норматив таблиц базы данных и функция автоматической реконструкции базы данных, что освободило разработчиков от необходимости конструировать sql-запросы вручную. А так же реализован внутренний самовызов из консоли, оттого на фоновый режим отработки была переведена отправка почтового сообщения и реструктуризация базы данных, что для пользователя значительно уменьшило время ожидания ответа, а у разработчиков отпала необходимость настраивать cron.

Стандарты: 

> Под стандартом понимается образец, эталон, модель.

- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/1.Стандарт кода.md">Стандарт кода</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/2.Стандарт среды.md">Стандарт среды</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/3.Стандарт разработчиков.md">Стандарт разработчиков</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/4.Стандарт компонентов.md">Стандарт компонентов</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/5.Стандарт разработки.md">Стандарт разработки</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Нормативы/Стандарт норматива базы данных.md">Стандарт норматива базы данных</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Нормативы/Стандарт норматива взаимодействия с базой данных.md">Стандарт норматива взаимодействия с базой данных</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Нормативы/Стандарт норматива наработок.md">Стандарт норматива наработок</a>


Структуры:

> Под структурами понимается внутреннее устройство, компоненты объекта вместе с их взаимосвязями.

- <a target="_blank" href="/Компоненты ядра/2.Представление/Структуры/Основа/Структура ролей разработчиков.md">Структура ролей разработчиков</a>
- <a target="_blank" href="/Компоненты ядра/2.Представление/Структуры/Основа/Структура компонентов.md">Структура компонентов</a>
- <a target="_blank" href="/Компоненты ядра/2.Представление/Структуры/База данных/Структура таблиц базы данных.md">Структура таблиц базы данных</a>
- <a target="_blank" href="/Компоненты ядра/2.Представление/Структуры/База данных/Структура взаимодействия с базой данных.md">Структура взаимодействия с базой данных</a>
- <a target="_blank" href="/Компоненты ядра/2.Представление/Структуры/Функции/Структура функций компонентов.md">Структура функций компонентов</a>
- <a target="_blank" href="/Компоненты ядра/2.Представление/Структуры/Функции/Структура функций сайта.md">Структура функций сайта</a>


Нормативы:

> Под нормативом понимается обязательный объем результата деятельности, которому всегда принято следовать.

- <a target="_blank" href="/Компоненты ядра/3.Аккумуляция/Нормативы/Компоненты/1.Норматив компонента орентировка.md">Норматив компонента орентировка</a>
- <a target="_blank" href="/Компоненты ядра/3.Аккумуляция/Нормативы/Компоненты/2.Норматив компонента представление.md">Норматив компонента представление</a>
- <a target="_blank" href="/Компоненты ядра/3.Аккумуляция/Нормативы/Компоненты/3.Норматив компонента аккумуляция.md">Норматив компонента аккумуляция</a>
- <a target="_blank" href="/Компоненты ядра/3.Аккумуляция/Нормативы/Компоненты/4.Норматив компонента движение.md">Норматив компонента движение</a>
- <a target="_blank" href="/Компоненты ядра/3.Аккумуляция/Нормативы/Компоненты/5.Норматив компонента модули.md">Норматив компонента модули</a>
- <a target="_blank" href="/Компоненты ядра/3.Аккумуляция/Нормативы/Функции/Норматив функций компонентов.md">Норматив функций компонентов</a>

<hr>

### Интерфейс

В интерфейсе реализована структура landing-page + ajax подгрузка данных с ядра по api, что позволяет пользователю взаимодействовать с сайтом без прерываний, а разработчику интерфейса иметь исходники без каких либо php-вставок.

Стандарты: 

> Под стандартом понимается образец, эталон, модель.

- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/1.Стандарт кода.md">Стандарт кода</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/2.Стандарт среды.md">Стандарт среды</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/3.Стандарт разработчиков.md">Стандарт разработчиков</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/4.Стандарт компонентов.md">Стандарт компонентов</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/5.Стандарт разработки.md">Стандарт разработки</a>

Структуры:

> Под структурами понимается внутреннее устройство, компоненты объекта вместе с их взаимосвязями.

- <a target="_blank" href="/Компоненты интерфейса/2.Представление/Структуры/Основа/Структура ролей разработчиков.md">Структура ролей разработчиков</a>
- <a target="_blank" href="/Компоненты интерфейса/2.Представление/Структуры/Основа/Структура компонентов.md">Структура компонентов</a>

Нормативы:

> Под нормативом понимается обязательный объем результата деятельности, которому всегда принято следовать.

- <a target="_blank" href="/Компоненты интерфейса/3.Аккумуляция/Нормативы/Компоненты/1.Норматив компонента орентировка.md">Норматив компонента орентировка</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Аккумуляция/Нормативы/Компоненты/2.Норматив компонента представление.md">Норматив компонента представление</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Аккумуляция/Нормативы/Компоненты/3.Норматив компонента аккумуляция.md">Норматив компонента аккумуляция</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Аккумуляция/Нормативы/Компоненты/4.Норматив компонента движение.md">Норматив компонента движение</a>
- <a target="_blank" href="/Компоненты интерфейса/3.Аккумуляция/Нормативы/Компоненты/5.Норматив компонента модули.md">Норматив компонента модули</a>

<hr>

### Разработка

Порядок разработки выстроен так, что равномерно переводит команду разработчиков на форму управления "холакратия", которая эффективна в непрерывной и распределительной разработке web-сайтов. При этом изучать холакратию не нужно, достаточно каждому участнику разработки соотвествовать нормативам.

> Холакратия — это способ децентрализации власти, который позволяет выстроить иерархию (холархию) таким образом, чтобы каждый сотрудник мог влиять на жизнь компании и обладал полной властью в рамках своей роли и возложенных на неё обязательств.


![Framework life balance](https://framework-life-balance.ru/Компоненты%20интерфейса/2.Представление/Картинки/illustrators/4values.jpg)

<hr>

### Примечание

Исходный код сайта https://framework-life-balance.ru подгружается с https://github.com/veter-love/framework-life-balance-v1 репозитория.