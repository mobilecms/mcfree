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
class guestbook_widget {
	/**
	* Показ виджета
	*/
	public static function display($widget_id) {
		$db = Registry::get('db');
		$messages = $db->get_one("SELECT COUNT(*) FROM #__guestbook");
		return '<img src="'. URL .'views/'. THEME .'/img/icon.png" alt="" /> <a href="'. a_url('guestbook') .'">Гостевая книга</a> <span class="small_text">['. $messages .']</span><br />';
	}

	/**
	* Настройка виджета
	*/
	public static function setup($widget) {
		a_notice('Данный виджет не требует настройки', a_url('index_page/admin'));
	}
}
?>