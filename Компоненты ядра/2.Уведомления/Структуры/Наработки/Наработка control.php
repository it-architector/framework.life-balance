<?php

namespace Framework_life_balance\core_components\experiences;

/**
 * Наработка control
 *
 * @package Framework_life_balance\core_components\experiences
 */
interface Structure_control
{
    /**
     * Главная контрольной панели
     *
     * @param array $parameters параметры
     * @return array
     */
    function index(array $parameters);

    /**
     * Ошибки ядра
     *
     * @param array $parameters параметры
     * @return array
     */
    function errors(array $parameters);

    /**
     * Пересборка таблиц и колонок в базе данных
     *
     * @param array $parameters параметры
     * @return string
     */
    function reassembly_data_base(array $parameters);

    /**
     * Отправляем письмо
     *
     * @param array $parameters параметры
     * @return string
     */
    function send_email(array $parameters);

}
