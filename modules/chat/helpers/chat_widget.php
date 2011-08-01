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
 * Виджет гостевой книги
 */
class chat_widget {
	/**
	* Показ виджета
	*/
	public static function display($widget_id) {
  		$db = Registry::get('db');
		$config = Registry::get('config');
		
  		$users_online = $db->get_one("SELECT COUNT(*) FROM #__users WHERE chat_last_time >= UNIX_TIMESTAMP() + ". $config['chat']['online_time'] ." * 60 AND user_id != '". USER_ID ."'");
		return '<img src="'. URL .'views/'. THEME .'/img/icon.png" alt="" /> <a href="'. a_url('chat') .'">Чат</a> <span class="small_text">['. $users_online .']</span><br />';
	}

	/**
	* Настройка виджета
	*/
	public static function setup($widget) {
		a_notice('Данный виджет не требует настройки', a_url('index_page/admin'));
	}
}
?>