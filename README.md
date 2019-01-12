# Framework life balance v1.0

Framework life balance предназначен для разработки web-сайтов на исходном php-коде, html-разметках ( css, image ) и js-скриптах, с чёткой последовательностью (смотрите <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/4.Стандарт разработки.md">стандарт разработки ядра</a>) введения новых модулей, схем и наработок, и возможностью распределить разработку web-сайта на 8 человек для разработки 8 компонентов web-сайта.

У Framework life balance два направления разработки: back-end (ядро) и front-end (интерфейс). Здесь нет места для php-кода в интерфейсе, и html-а в ядре. Ядро и интерфейс разделены и изолированы, что позволяет безпрепятственно разрабатывать оба направления одновременно, почтительно дополняя (без возникновения каких либо merge) на git'e.

Порядок разработки и структура фреймворка выстроена так, что позволяет компаниям равномерно перейти на форму управления "холакратия" для беспрепятственно разрабатывания web-сайтов, при этом раскрывая особенности разработчиков и вводя всё больше автономности, высвобождая человеческие ресурсы и оперативно устраняя участки большого напряжения в команде.

![Framework life balance](https://framework-life-balance.ru/Компоненты%20интерфейса/2.Представления/Картинки/slider/slide1_bg.jpg)

В интерфейсе реализована структура landing-page + ajax подгрузка данных с ядра по api, что позволяет пользователю взаимодействовать с сайтом без прерываний, а разработчику интерфейса иметь исходники без каких либо php-вставок.

В ядре реализованы Стандарты (детализация) ядра, наглядность Структуры (планировка), 4-е Сути (распределенная альтернатива контролёров в mvc), Наработки (упрощённая альтернатива моделей в mvc) и Схемы (упрощённая альтернатива yii2 migrate, установки и настроек). Благодаря такому подходу была реализована схема всех таблиц в одном файле и автоматическая по ней реконструкция базы данных, что у разработчиков высвободила время и ввела наглядность базы данных. А так же реализован внутренний самовызов из консоли, оттого на фоновый режим отработки была переведена отправка почтового сообщения и реструктуризация базы данных, что для пользователя значительно уменьшило время ожидания ответа, а у разработчиков отпала необходимость настраивать cron.

<a target="_blank" href="https://framework-life-balance.ru/#about">Подробнее о проекте</a> (в том числе про этапы развёртки).

<hr>

Реализованные цели интефрейса:
1. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Цели/1.Цель релиза Framework life balance v1.md">Цель релиза Framework life balance v1</a>

Стандарты интерфейса:
1. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Стандарты/1.Стандарт разработчиков.md">Стандарт разработчиков</a>
2. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Стандарты/2.Стандарт разработки.md">Стандарт разработки</a>
3. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Стандарты/3.Стандарт компонентов.md">Стандарт компонентов</a>

Нормативы интерфейса:
1. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Нормативы/1.Норматив java script.md">Норматив java script</a>
2. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Нормативы/2.Норматив дизайна.md">Норматив дизайна</a>
3. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Нормативы/3.Норматив css.md">Норматив css</a>
4. <a target="_blank" href="/Компоненты интерфейса/1.Интеллект/Нормативы/4.Норматив блоков.md">Норматив блоков</a>

Изменения интерфейса:
1. <a target="_blank" href="/Компоненты интерфейса/4.Формы/Изменения/1.Изменения под релиз Framework life balance v1.md">Изменения под релиз Framework life balance v1</a>

<hr>

Реализованные цели ядра:
1. <a target="_blank" href="/Компоненты ядра/1.Решения/Цели/1.Цель релиз Framework life balance v1.md">Цель релиз Framework life balance v1</a>

Стандарты ядра:
1. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/1.Стандарт сервера.md">Стандарт сервера</a>
2. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/2.Стандарт сайта.md">Стандарт сайта</a>
3. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/3.Стандарт разработчиков.md">Стандарт разработчиков</a>
4. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/4.Стандарт разработки.md">Стандарт разработки</a>
5. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/5.Стандарт компонентов.md">Стандарт компонентов</a>
6. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/6.Стандарт модулей.md">Стандарт модулей</a>
7. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/7.Стандарт схемы_наработок.md">Стандарт схемы наработок</a>
8. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/8.Стандарт схемы базы данных.md">Стандарт схемы базы данных</a>
9. <a target="_blank" href="/Компоненты ядра/1.Решения/Стандарты/9.Стандарт модуля базы данных mysql.md">Стандарт модуля базы данных mysql</a>

Нормативы ядра:
1. <a target="_blank" href="/Компоненты ядра/1.Решения/Нормативы/1.Норматив оптимизации.md">Норматив оптимизации</a>
2. <a target="_blank" href="/Компоненты ядра/1.Решения/Нормативы/2.Норматив смысла.md">Норматив смысла</a>
3. <a target="_blank" href="/Компоненты ядра/1.Решения/Нормативы/3.Норматив обеспечения.md">Норматив обеспечения</a>
4. <a target="_blank" href="/Компоненты ядра/1.Решения/Нормативы/4.Норматив выполнения.md">Норматив выполнения</a>

Изменения ядра:
1. <a target="_blank" href="/Компоненты ядра/4.Дела/Протоколы/Изменения/1.Изменения под релиз Framework life balance v1.md">Изменения под релиз Framework life balance v1</a>

<hr>

p.s. Холакратия — это способ децентрализации власти, который позволяет выстроить иерархию (холархию) таким образом, чтобы каждый сотрудник мог влиять на жизнь компании и обладал полной властью в рамках своей роли и возложенных на неё ожиданий.

p.s. Исходный код сайта https://framework-life-balance.ru подгружается с данного репозитория.