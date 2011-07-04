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
 * Хелпер событий модуля событий
 */
class downloads_events {
	/**
	* Перед выполнением контроллера
	*/
	public static function pre_controller(&$db) {
		echo 'Событие модуля загрузок вызванное перед контроллером';
	}
}
?>