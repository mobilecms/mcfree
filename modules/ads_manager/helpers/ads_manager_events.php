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
class ads_manager_events {
	/**
	* Перед выполнением контроллера
	*/
	public static function pre_controller(&$db) {
		a_import('modules/ads_manager/helpers/ads_manager');
		$ads_manager_links = ads_manager::get_links(&$db);
		
		Registry::set('ads_manager_links', $ads_manager_links);
	}
}
?>