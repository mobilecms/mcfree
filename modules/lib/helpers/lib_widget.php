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
class lib_widget {
	/**
	* Показ виджета
	*/
	public static function display($widget_id) {
  		$db = Registry::get('db');
  		$stat = $db->get_row("SELECT COUNT(*) AS all_books, COUNT(CASE WHEN time > UNIX_TIMESTAMP() - 86400 THEN 1 END) AS new_books FROM #__lib_books");
		return '<img src="'. URL .'views/'. THEME .'/img/icon.png" alt="" /> <a href="'. a_url('lib') .'">Библиотека</a> <span class="small_text">['. $stat['all_books'] .']</span>'. ($stat['new_books'] > 0 ? ' <span class="new_files">+'. $stat['new_books'] .'</span>' : '') .'<br />';
	}

	/**
	* Настройка виджета
	*/
	public static function setup($widget) {
		a_notice('Данный виджет не требует настройки', a_url('index_page/admin'));
	}
}
?>