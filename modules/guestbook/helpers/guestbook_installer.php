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
 * Хелпер установки модуля
 */
class guestbook_installer {
	/**
	* Установка модуля
	*/
	public static function install(&$db) {
    	$db->query("CREATE TABLE #__guestbook (
			`message_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`user_id` INT NOT NULL ,
			`username` VARCHAR( 30 ) NOT NULL ,
			`message` VARCHAR( 300 ) NOT NULL ,
			`time` INT NOT NULL
			) ENGINE = MYISAM ;
		");
	}

	/**
	* Деинсталляция модуля
	*/
	public static function uninstall(&$db) {
		$db->query("DROP TABLE #__guestbook ;");
	}
}
?>