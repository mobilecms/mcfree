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
class forum_widget {
	/**
	* Показ виджета
	*/
	public static function display($widget_id) {
  		$db = Registry::get('db');
  		$stat = $db->get_row("SELECT
  			(SELECT COUNT(*) FROM #__forum_topics) AS topics,
  			(SELECT COUNT(*) FROM #__forum_messages) AS messages
  		");
		return '<img src="'. URL .'views/'. THEME .'/img/icon.png" alt="" /> <a href="'. a_url('forum') .'">Форум</a> <span class="small_text">['. $stat['topics'] .'/'. $stat['messages'] .']</span><br />';
	}

	/**
	* Настройка виджета
	*/
	public static function setup($widget) {
		a_notice('Данный виджет не требует настройки', a_url('index_page/admin'));
	}
}
?>