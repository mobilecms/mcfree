<?php

/**
 * Photoalbums
 *
 * @package
 * @author Platonov Kirill <platonov-kd@ya.ru>
 * @link http://twitter.com/platonov_kd
 */

defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа!</b>');

/**
 * Виджет фотоальбомов
 */
class photo_widget {
	/**
	* Показ виджета
	*/
	public static function display($widget_id) {
		$db = Registry::get('db');
		$albums = $db->get_one("SELECT COUNT(*) FROM #__photo_albums");
		$photos = $db->get_one("SELECT COUNT(*) FROM #__photo");
		
		return '<img src="'. URL .'views/'. THEME .'/img/icon.png" alt="" /> <a href="'. a_url('photo') .'">Фотоальбомы</a> <span class="small_text">['. $albums .'/'. $photos .']</span><br />';
	}

	/**
	* Настройка виджета
	*/
	public static function setup($widget) {
  	a_notice('Данный виджет не требует настройки', a_url('index_page/admin'));
	}
}

?>
