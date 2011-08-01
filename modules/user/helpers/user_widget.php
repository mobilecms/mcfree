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
 * Виджет модуля пользователей
 */
class user_widget {
	/**
	* Показ виджета
	*/
	public static function display($widget_id) {
  		$db = Registry::get('db');
  		$users = $db->get_row("SELECT
  			(SELECT COUNT(*) FROM #__users WHERE user_id != -1) AS `all`,
  			(SELECT COUNT(*) FROM #__users WHERE user_id != -1 AND last_visit > UNIX_TIMESTAMP() - 600) AS online
  		");
  		
		return '<img src="'. URL .'views/'. THEME .'/img/icon.png" alt="" /> <a href="'. a_url('user/list_users') .'">Пользователи</a> <span class="small_text">['. $users['online'] .'/'. $users['all'] .']</span><br />';
	}

	/**
	* Настройка виджета
	*/
	public static function setup($widget) {
		a_notice('Данный виджет не требует настройки', a_url('index_page/admin'));
	}
}
?>