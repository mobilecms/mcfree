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
 * Хелпер модуля главной страницы
 */
class index_page {
	/**
	* Получение списка доступных виджетов
	*/
	public static function get_widgets() {
		modules::initialize();
		$modules = Registry::get('modules');
		
		$widgets = array();
		$dir = opendir(ROOT .'modules/');
		while($module = readdir($dir)) {
			if(file_exists(ROOT .'modules/'. $module .'/helpers/'. $module .'_widget.php') && (modules::is_active_module($module) || $module = 'user')) {
				if(!empty($modules[$module]['title'])) $widgets[$module] = $modules[$module]['title'];
				else {
					$module_info = parse_ini_file(ROOT .'modules/'. $module .'/module.ini');
					$widgets[$module] = $module_info['title'];
				}
			}
		}
		return $widgets;
	}
}
?>