<?php

/**
 * MobileCMS
 * Content Management System for creation of mobile sites.
 * @package MobileCMS
 * @author http://mobilecms.ru/mobilecms/authors.php
 * @copyright Copyright (c) 2006-2011, MobileCMS
 * @license http://mobilecms.ru/mobilecms/license.php
 * @link http://mobilecms.ru/
 */

defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа!</b>');

/**
 * Хелпер событий модуля пользователей
 */
class user_events {
	/**
	* Перед выполнением контроллера
	*/
	public static function pre_controller(&$db) {
	     $tpl = Registry::get('tpl');
	
		# Проверяем наличие пользователя в списке забаненых
		if (USER_ID != -1 && $ban = $db->get_row("SELECT * FROM #__users_ban WHERE user_id = '". USER_ID ."' AND status = 'enable'")) {
			# Если время бана истекло
			if ($ban['to_time'] <= TIME()) {
				$db->query("UPDATE #__users_ban SET status = 'disable' WHERE ban_id = '". $ban['ban_id'] ."'");
			} else {
				if (ROUTE_MODULE != 'user') header('Location: '. URL .'user/');
			}
			
			# Удаляем мусор
			if ($db->get_one("SELECT COUNT(*) FROM #__users_ban WHERE user_id = '". USER_ID ."' AND status = 'enable' AND ban_id != '". $ban['ban_id'] ."'") != 0) $db->query("DELETE FROM #__users_ban WHERE user_id = '". USER_ID ."' AND status = 'enable' AND ban_id != '". $ban['ban_id'] ."'");
		}
	}
}

?>