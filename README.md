# Framework life balance [ ядро v1.1.8.8 / интерфейс v1.0.7.8 ]

Framework life balance предназначен для **сопровождения** всех этапов разработки отеческого сайта с любым масштабом на исходном php-коде, html-разметках ( css, image ) и js-скриптах, с применением чёткой последовательностью разработки (смотрите <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/4.Стандарт разработки.md">стандарт разработки ядра</a> и <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/4.Стандарт разработки.md">стандарт разработки интерфейса</a>) 10 компонентов сайта:

| № | Компоненты ядра | Компоненты интерфейса
 ------------- |  ------------- | ------------- | 
| 1. | Ориентировка: цели, сведения, стандарты | Ориентировка: цели, сведения, стандарты
| 2. | Представления: структуры | Представления: дизайн, картинки
| 3. | Ресурсы: нормативы, схемы | Ресурсы: нормативы, блоки, стили, шрифты
| 4. | Интеллект: протоколы, функции | Интеллект: протоколы, функции
| 5. | Модули | Модули

<a target="_blank" href="https://framework-life-balance.ru/#about">Подробнее о проекте</a> (в том числе про этапы развёртки).


<hr>

### Среда

У Framework life balance две среды разработки: back-end (ядро) и front-end (интерфейс). Здесь нет места для php-кода в интерфейсе, и html-а в ядре. Ядро и интерфейс разделены и изолированы, что позволяет безпрепятственно разрабатывать оба направления одновременно, почтительно дополняя (без возникновения каких либо merge) на git'e.

![Framework life balance](https://framework-life-balance.ru/Компоненты%20интерфейса/2.Представления/Картинки/slider/slide1_bg.jpg)

<hr>

### Ядро

В ядре реализованы Стандарты (детализации) ядра, наглядность Структуры (планировка), 4-е Сути (распределенная альтернатива контролёров в mvc), Наработки (упрощённая альтернатива моделей в mvc) и Схемы (упрощённая альтернатива yii2 migrate, установки и настроек). Благодаря такому подходу была реализована Схема таблиц базы данных и автоматическая реконструкция базы данных, что освободило разработчиков от необходимости формировать запросы до кучи. А так же реализован внутренний самовызов из консоли, оттого на фоновый режим отработки была переведена отправка почтового сообщения и реструктуризация базы данных, что для пользователя значительно уменьшило время ожидания ответа, а у разработчиков отпала необходимость настраивать cron.

Стандарты: 

> Под стандартом понимается образец, эталон, модель.

- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/1.Стандарт ядра.md">Стандарт ядра</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/2.Стандарт разработчиков.md">Стандарт разработчиков</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/3.Стандарт компонентов.md">Стандарт компонентов</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/4.Стандарт разработки.md">Стандарт разработки</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Схемы/Стандарт схемы базы данных.md">Стандарт схемы базы данных</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Схемы/Стандарт схемы взаимодействия с базой данных.md">Стандарт схемы взаимодействия с базой данных</a>
- <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Схемы/Стандарт схемы наработок.md">Стандарт схемы наработок</a>

Нормативы:

> Под нормативом понимается обязательный объем результата, которому всегда принято следовать.

1. <a target="_blank" href="/Компоненты ядра/3.Ресурсы/Нормативы/1.Норматив орентировки.md">Норматив орентировки</a>
2. <a target="_blank" href="/Компоненты ядра/3.Ресурсы/Нормативы/2.Норматив представлений.md">Норматив представлений</a>
3. <a target="_blank" href="/Компоненты ядра/3.Ресурсы/Нормативы/3.Норматив ресурсов.md">Норматив ресурсов</a>
4. <a target="_blank" href="/Компоненты ядра/3.Ресурсы/Нормативы/4.Норматив интеллекта.md">Норматив интеллекта</a>
5. <a target="_blank" href="/Компоненты ядра/3.Ресурсы/Нормативы/5.Норматив модулей.md">Норматив модулей</a>

<hr>

### Интерфейс

В интерфейсе реализована структура landing-page + ajax подгрузка данных с ядра по api, что позволяет пользователю взаимодействовать с сайтом без прерываний, а разработчику интерфейса иметь исходники без каких либо php-вставок.

Стандарты: 

> Под стандартом понимается образец, эталон, модель.

- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/1.Стандарт интерфейса.md">Стандарт интерфейса</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/2.Стандарт разработчиков.md">Стандарт разработчиков</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/3.Стандарт компонентов.md">Стандарт компонентов</a>
- <a target="_blank" href="/Компоненты интерфейса/1.Ориентировка/Стандарты/Основа/4.Стандарт разработки.md">Стандарт разработки</a>

Нормативы:

> Под нормативом понимается обязательный объем результата, которому всегда принято следовать.

1. <a target="_blank" href="/Компоненты интерфейса/3.Ресурсы/Нормативы/1.Норматив орентировки.md">Норматив орентировки</a>
2. <a target="_blank" href="/Компоненты интерфейса/3.Ресурсы/Нормативы/2.Норматив представлений.md">Норматив представлений</a>
3. <a target="_blank" href="/Компоненты интерфейса/3.Ресурсы/Нормативы/3.Норматив ресурсов.md">Норматив ресурсов</a>
4. <a target="_blank" href="/Компоненты интерфейса/3.Ресурсы/Нормативы/4.Норматив интеллекта.md">Норматив интеллекта</a>
5. <a target="_blank" href="/Компоненты интерфейса/3.Ресурсы/Нормативы/5.Норматив модулей.md">Норматив модулей</a>

<hr>

### Разработка

Порядок разработки выстроен так, что равномерно переводит команду разработчиков на форму управления "холакратия", которая эффективна в непрерывной и распределительной разработке web-сайтов. При этом изучать холакратию не нужно, достаточно каждому участнику разработки соотвествовать ожиданиям (смотрите <a target="_blank" href="/Компоненты ядра/1.Ориентировка/Стандарты/Основа/2.Стандарт разработчиков.md">стандарт разработчиков ядра</a>).

> Холакратия — это способ децентрализации власти, который позволяет выстроить иерархию (холархию) таким образом, чтобы каждый сотрудник мог влиять на жизнь компании и обладал полной властью в рамках своей роли и возложенных на неё ожиданий.


![Framework life balance](https://framework-life-balance.ru/Компоненты%20интерфейса/2.Представления/Картинки/illustrators/4values.jpg)

<hr>

### Примечание

Исходный код сайта https://framework-life-balance.ru подгружается с https://github.com/veter-love/framework-life-balance-v1 репозитория.