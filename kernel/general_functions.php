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

defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа</b>');

/**
* Подключение файла
*/
function a_import($file) {
	if(!strstr($file, '.php')) $file .= '.php';
	if(file_exists(ROOT . $file)) {
		include_once ROOT . $file;
		return TRUE;
	}
	else {
		a_error($file .': Подключаемый файл не найден!');
		return FALSE;
	}

}


/**
* Вывод ошибки
*/
function a_error($error_message = '', $fatal_error = TRUE) {
	$tpl = Registry::get('tpl');
	
	if(empty($error_message)) $error_message = 'Произошла неизвестная ошибка';

	if(!empty($tpl)) {
		$tpl->assign(array(
			'error_message' => $error_message,
			'from' => 'info'
		));
		$tpl->display('error');
	}
	else {
		echo '<b>'. $error_message .'</b>';
	}

	if($fatal_error) exit;
}


/**
* Вывод информирующего сообщения
*/
function a_notice($message, $link, $timeout = 5) {
	$tpl = Registry::get('tpl');

	if(isset($tpl)) {
		$tpl->assign(array(
			'title' => 'Информация',
			'message' => $message,
			'link' => $link,
			'timeout' => $timeout,
			'from' => 'info'
		));

		$tpl->display('notice');
	}
	else {
		echo '<b>'. $message .'</b><br />';
		echo '<a href="'. $link .'">Продолжить</a>';
	}
	exit;
}


/**
* Подтверждение
*/
function a_confirm($message, $link_ok, $link_cancel) {
	$tpl = Registry::get('tpl');

	if(empty($message)) $message = 'Подтверждаете выполнение данного действия?';

	if(isset($tpl)) {
		$tpl->assign(array(
			'message' => $message,
			'link_ok' => $link_ok,
			'link_cancel' => $link_cancel
		));

		$tpl->display('confirm');
	}
	else {
		echo '<b>'. $message .'</b><br />';
		echo '<a href="'. $link_ok .'">Да</a> | <a href="'. $link_cancel .'">Нет</a>';
	}
	exit;
}


/**
* Генерация URL адреса
*/
function a_url($path, $query = '', $header = FALSE) {
	if(!empty($query)) {
		if($header) $query = '&'. $query;
		else $query = '&amp;'. $query;
	}
	$url = URL . $path . EXT .'?'. SID . $query;
	$url = str_replace('?&amp;', '?', $url);
	$url = str_replace('?&', '?', $url);

	if(substr($url, -1) == '?') $url = substr($url, 0, -1);

	return $url;
}


/**
* Обработка строки для помещения ее в базу данных
*/
function a_safe($str) {
	return htmlspecialchars(mysql_real_escape_string(trim($str)), ENT_NOQUOTES);
}


/**
* Вывод дампа переменной
*/
function a_debug($var, $exit = TRUE) {
	print '<pre>';
	print_r($var);
	print '</pre>';

	if($exit) exit;
}

/**
* Онлайн ли пользователь
*/
function a_is_online($last_visit) {
	if($last_visit > time() - 600) return '<span style="color: green;">On</span>';
	else return '<span style="color: red;">Off</span>';
}

/**
* Небольшой профайлер приложения
*/
function a_profiler($start_time) {
	GLOBAL $db;

	$end_time = microtime(true);

	echo PHP_EOL .'<!-- '. PHP_EOL;
	echo 'Время выполнения: '. round($end_time - $start_time, 5) .' сек.'. PHP_EOL . PHP_EOL;
	if($db) {
		echo 'Запросов к БД: '. count($db->list_queries) . PHP_EOL;
		if(count($db->list_queries) > 0) {
			foreach($db->list_queries AS $query_data) {
				echo $query_data['query'] .' ('. round($query_data['time'], 5) .' сек.)'. PHP_EOL;
			}
		}
	}
	else {
		echo "Подключения к базе не было.";
	}
	echo PHP_EOL . PHP_EOL;
	echo 'GET данные:'. PHP_EOL;
	print_r($_GET);
	echo PHP_EOL . PHP_EOL;
	echo 'POST данные:'. PHP_EOL;
	print_r($_POST);
	echo ' -->';
}

/**
* Если переменная пуста, функция возвращает значение по умолчанию
*/
function a_default($var, $default = 0) {
	if(empty($var)) return $default;
	return $var;
}

/**
 * Подключение и инициализация класса
 *
 * @param <type> $path_to_class
 * @param <type> $type
 * @return class_name
 */
function a_load_class($path_to_class, $type = '') {
	# Подключем файл класса
	a_import($path_to_class);

	# Определяем имя класса
	$file_name = str_replace('.php', '', basename($path_to_class));
	$ex = explode('_', $file_name);
	foreach($ex as $value) $array[] = ucfirst($value);
	$class_name = implode('_', $array);

	switch($type) {
		case 'controller':
			$class_name = $class_name . '_Controller';
			break;
		case 'ci':
			$class_name = 'CI_'. $class_name;
			break;
	}

	# Инициализируем класс
	return new $class_name();
}

/**
* Функция антифлуда
*/
function a_antiflud($error = '', $antiflud_time = 0) {
	$config = Registry::get('config');
	
	if($antiflud_time == 0) $antiflud_time = $config['system']['antiflud_time'];
	if(empty($error)) $error = 'Отправляйте сообщения не раньше '. $antiflud_time .' секунд с момента последнего поста!';
	else $error = str_replace('{ANTIFLUD_TIME}', $antiflud_time, $error);

	if($_SESSION['last_message_time'] > time() - $antiflud_time) a_error($error);
	else $_SESSION['last_message_time'] = time();
}

/**
* Функция проверки прав пользователя на выполнение определенных действий
*/
function a_check_rights($check_user_id, $check_user_status) {
	if(USER_ID == -1) return FALSE;
	if(!class_exists('Access')) a_import('libraries/access');
	$access = new Access;
	$access_level = $access->get_level($check_user_status);
	if((ACCESS_LEVEL > $access_level && ACCESS_LEVEL > 5) OR $check_user_id == USER_ID ) return TRUE;
	else return FALSE;
}

/**
* htmlspecialchars for arrays
*/
function htmlspecialchars_array($var) {
	if(!is_array($var)) return htmlspecialchars($var);
	return false;
}

if(!function_exists('file_put_contents')) {
	function file_put_contents($file, $data) {
		$fp = fopen ($file, "w+");
		fwrite ($fp, $data);
		fclose ($fp);
	}
}

if(!function_exists('parse_ini_string')){
	function parse_ini_string( $string ) {
		$array = Array();

		$lines = explode("\n", $string );

		foreach( $lines as $line ) {
			$statement = preg_match("/^(?!;)(?P<key>[\w+\.\-]+?)\s*=\s*(?P<value>.+?)\s*$/", $line, $match );

			if( $statement ) {
				$key    = $match[ 'key' ];
				$value    = $match[ 'value' ];

				# Remove quote
				if( preg_match( "/^\".*\"$/", $value ) || preg_match( "/^'.*'$/", $value ) ) {
					$win_value = iconv('utf-8', 'windows-1251', $value);
					$win_value = substr($win_value, 1, strlen($win_value) - 2);
					$value = iconv('windows-1251', 'utf-8', $win_value);
				}

				 $array[$key] = $value;
			}
		}
		return $array;
	}
}

function highlight($str) {
	$str = stripslashes(htmlspecialchars_decode($str));
	$str = highlight_string($str, true);
	return '<div style="border: 1px silver solid; margin: 10px; padding-left: 5px; background-color: #f1f2f1;">'.$str.'</div>';
}
?>