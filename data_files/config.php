<?php
/**
 * MobileCMS
 *
 * Open source content management system for mobile sites
 *
 * @author MobileCMS Team <support@mobilecms.ru>
 * @copyright Copyright (c) 2011, MobileCMS Team
 * @link http://mobilecms.ru Official site
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Конфигурация для публичного сервера
 */
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
    # База данных
    define('DB_BASE', 'mc2');
    # Хост базы данных
    define('DB_HOST', 'localhost');
    # Имя пользователя
    define('DB_USER', 'root');
    # Пароль
    define('DB_PASS', 'Ufm391em1532');
    # Вывод ошибок
    define('DB_DEBUGGING', TRUE);
    # Префикс таблиц
    define('DB_PREFIX', 'a_');

    # URL скрипта (с http:// и слешем в конце). Например, http://mobilecms.ru/
    define('URL', 'http://82.209.118.133/mc2/');
}

/**
 * Конфигурация для локального сервера
 */
else {
    # База данных
    define('DB_BASE', 'mc2');
    # Хост базы данных
    define('DB_HOST', 'localhost');
    # Имя пользователя
    define('DB_USER', 'root');
    # Пароль
    define('DB_PASS', 'Ufm391em1532');
    # Вывод ошибок
    define('DB_DEBUGGING', TRUE);
    # Префикс таблиц
    define('DB_PREFIX', 'a_');

    # URL скрипта (с http:// и слешем в конце). Например, http://mobilecms.ru/
    define('URL', 'http://82.209.118.133/mc2/');
}
?>