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
class news_installer {
	/**
	* Установка модуля
	*/
	public static function install(&$db) {
		$db->query("CREATE TABLE #__news (
			  `news_id` int(11) NOT NULL auto_increment,
			  `subject` varchar(100) NOT NULL,
			  `text` text NOT NULL,
			  `time` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
		");
	}

	/**
	* Деинсталляция модуля
	*/
	public static function uninstall(&$db) {
		$db->query("DROP TABLE #__news;");
	}
}
?>