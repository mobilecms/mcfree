<?php
/**
 * Ant0ha's project
 *
 * @package
 * @author Anton Pisarenko <wapwork@bk.ru>
 * @copyright Copyright (c) 2006 - 2010, Anton Pisarenko
 * @license http://ant0ha.ru/license.txt
 * @link http://ant0ha.ru
 */

defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа!</b>');

//---------------------------------------------

/**
 * Ежедневные действия в системе
 */
if(file_get_contents(ROOT .'data_files/day.dat') != date('d')) {
	file_put_contents(ROOT .'data_files/day.dat', date('d'));
	$db = Registry::get('db');

	// Очистка таблицы гостей
    $db->query("DELETE FROM #__guest WHERE last_time < UNIX_TIMESTAMP() - 600");

	# Чистим tmp/
	main::tmp_clear();
	# Сборка мусора в загрузках
	if(modules::is_active_module('downloads')) $db->query("DELETE FROM #__downloads_files WHERE real_name = ''");
	# Удаление старых логов рейтинга
	$db->query("DELETE FROM #__rating_logs WHERE time < UNIX_TIMESTAMP() - 7 * 86400");
}

?>