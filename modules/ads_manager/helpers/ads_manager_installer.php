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
class ads_manager_installer {
	/**
	* Установка модуля
	*/
	public static function install(&$db) {
		$db->query("CREATE TABLE IF NOT EXISTS #__ads_manager_areas (
			  `area_id` int(11) NOT NULL auto_increment,
			  `title` varchar(50) NOT NULL,
			  `ident` varchar(50) NOT NULL,
			  PRIMARY KEY  (`area_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		");

		$db->query("CREATE TABLE IF NOT EXISTS #__ads_manager_links (
			  `link_id` int(11) NOT NULL auto_increment,
			  `area_id` int(11) NOT NULL,
			  `area_ident` varchar(50) NOT NULL,
			  `title` varchar(50) NOT NULL,
			  `url` varchar(255) NOT NULL,
			  `names` text NOT NULL,
			  `position` int(11) NOT NULL,
			  `count_all` int(11) NOT NULL,
			  PRIMARY KEY  (`link_id`),
			  KEY `area_id` (`area_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		");

		main::add_event('ads_manager', 'pre_controller');
	}

	/**
	* Деинсталляция модуля
	*/
	public static function uninstall(&$db) {
		$db->query("DROP TABLE #__ads_manager_areas, #__ads_manager_links ;");
		main::delete_event('ads_manager');
	}
}
?>