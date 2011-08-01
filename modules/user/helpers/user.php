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
 * Хелпер модуля пользователей
 */
class user {
	/**
	* Довавление рейтинга пользователю
	*/
	public static function rating_update($rating = 1, $user_id = NULL) {
		if(!$user_id) $user_id = USER_ID;
		$rating = floatval($rating);

		$db = Registry::get('db');
		if($user_id != -1) $db->query("UPDATE #__users SET rating = rating + $rating WHERE user_id = $user_id");
	}
}
?>