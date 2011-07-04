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

//----------------------------------------
/**
* Простенький класс управления доступом
*/
class Access {
	/**
	* Роли и права
	*/
	public $levels = array(
		'admin' => 10,
		'moder' => 8,
		'user' => 5,
		'banned' => 2,
		'guest' => 1
	);

	/**
	* Русские названия ролей
	*/
	public $ru_roles = array(
		'admin' => 'Админ',
		'moder' => 'Модер',
		'user' => 'Пользователь',
		'banned' => 'Забаннен',
		'guest' => 'Гость'
	);

	/**
	* Назначение прав
	*/
	function set_levels($levels) {
		$this->levels = $levels;
	}

	/**
	* Получить уровень по роли
	*/
	function get_level($status) {
		return $this->levels[$status];
	}

	/**
	* Проверка доступа
	*/
	function check_access($level) {
		if($level >= $this->get_level($GLOBALS['USER']['status'])) return TRUE;
		return FALSE;
	}

	/**
	* Проверка уровня доступа и сообщение об ошибке, если доступ запрещен
	*/
	function check($level) {
		if($level > ACCESS_LEVEL) a_error('Доступ запрещен!');
	}
}

?>