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
a_import('libraries/smarty/Smarty.class');

//----------------------------------------
/**
 * My Smarty class
 *
 * @author Ant0ha
 */
class MY_Smarty extends Smarty {
	public $_globals = array();
	public $theme = 'default';
	public $template_dir;

	function display($resource_name, $cache_id = NULL){
		$this->template_dir = ROOT;
		if(strpos($resource_name, '.tpl') == FALSE) $resource_name = $resource_name .'.tpl';

		# Определяем имя файла шаблона
		if(file_exists(ROOT . 'modules/'. ROUTE_MODULE .'/views/'. $this->theme .'/smarty/'. $resource_name)) {
		$resource_name = 'modules/'. ROUTE_MODULE .'/views/'. $this->theme .'/smarty/'. $resource_name;
		}
		elseif(file_exists(ROOT .'/views/'. $this->theme .'/smarty/'. $resource_name)) {
		$resource_name = '/views/'. $this->theme .'/smarty/'. $resource_name;
		}
		else die('Файл <b>'. $resource_name .'</b> не является шаблоном или не найден.');

		return parent::display($resource_name, $cache_id);
	}

}

function insert_header($params){
	if (empty($params['content'])) {
       	return;
   	}
  	header($params['content']);
   	return;
}

?>