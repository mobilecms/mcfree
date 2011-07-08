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

defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа</b>');

/**
 * Контроллер пользователей
 */
class User_Controller extends Controller {
	/**
	* Уровень пользовательского доступа
	*/
	protected $access_level = 0;
	
	/**
	* Construct
	*/
	public function __construct() {
		parent::__construct();
		
		$tpl = Registry::get('tpl');

		// Проверка бана пользователя
		if (is_user() && $this->ban = $this->db->get_row("SELECT * FROM #__users_ban WHERE user_id = '". USER_ID ."' AND status = 'enable'")) {
			// Если время бана истекло
			if ($this->ban['to_time'] <= TIME()) {
				$this->db->query("UPDATE #__users_ban SET status = 'disable' WHERE ban_id = '". $this->ban['ban_id'] ."'");
			}
			else {
                $this->ban['to_time'] = $this->ban['to_time'] - TIME();

				$tpl->assign(array(
					'ban' => $this->ban
				));

				$tpl->display('ban');
				exit;
			}
		}
		
		if ( ! $_SESSION['login_errors']) $_SESSION['login_errors'] = 0;
	}

	/**
	* Метод по умолчанию
	*/
	public function action_index() {
		if (is_user()) redirect('user/profile');
		else $this->action_login();
	}

	/**
	* Регистрация пользователей
	*/
	public function action_registration() {
	    // Если пользователь уже авторизирован
		if (is_user()) {
			redirect('user/profile');
		}
	
		if (isset($_POST['submit'])) {
			// Проверка данных регулярками
			if (!main::check_input($_POST['username'], 'LOGIN')) $this->error .= 'Неверно указан логин, формат правильного: '. main::check_input('', 'LOGIN', 'format') .'<br />';
			
			if (!main::check_input($_POST['email'], 'MAIL')) $this->error .= 'Неверно указан e-mail адрес, формат правильного: '. main::check_input('', 'MAIL', 'format') .'<br />';
			
			if (!main::check_input($_POST['password'], 'PASSWORD')) $this->error .= 'Неверно указан пароль, формат правильного: '. main::check_input('', 'PASSWORD', 'format') .'<br />';
			
			if ($_POST['password'] != $_POST['password2']) $this->error .= 'Пароли не совпадают<br />';
			
			// Проверка имени пользователя на занятость
			if ($this->db->get_one("SELECT user_id FROM #__users WHERE username = '". a_safe($_POST['username']) ."'")) $this->error .= 'Указанное имя пользователя уже занято!<br />';
			
			// Проверка e-mail на занятость
			if ($this->db->get_one("SELECT user_id FROM #__users WHERE email = '". a_safe($_POST['email']) ."'")) $this->error .= 'Указанный e-mail адрес уже занят!<br />';
			
			// Проверка кода с картинки
			if ($_POST['captcha_code'] != $_SESSION['captcha_code']) $this->error .= 'Неверно указан код с картинки<br />';

			if(!$this->error) {
				# Регистрируем пользователя
				$this->db->query("INSERT INTO #__users SET
				 	username = '". a_safe($_POST['username']) ."',
				 	email = '". a_safe($_POST['email']) ."',
				 	password = '". md5(md5($_POST['password'])) ."',
				 	reg_time = '". time() ."',
				 	last_visit = UNIX_TIMESTAMP()
				");

				$user_id = $this->db->insert_id();
				$this->db->query("INSERT INTO #__users_profiles SET user_id = '$user_id'");

				# генерируем и отсылаем письмо
				$msg = file_get_contents(ROOT .'data_files/email/reg_message.tpl');

				$msg = str_replace('{SYSTEM_TITLE}', $this->config['system']['system_title'], $msg);
				$msg = str_replace('{USERNAME}', $_POST['username'], $msg);
				$msg = str_replace('{PASSWORD}', $_POST['password'], $msg);

				# Подключаем библиотеку email
				a_import('libraries/email');
				$this->email = new CI_Email;

				$this->email->from($this->config['system']['system_email']);
				$this->email->to($_POST['email']);

				$this->email->subject('Регистрация на сайте '. $this->config['system']['system_title']);
				$this->email->message($msg);

				$this->email->send();

				# авторизуем пользователя
				$_SESSION['user_id'] = $user_id;

				a_notice('Вы успешно зарегистрированы, на ваш электронный ящик высланы все необходимые данные!', a_url($this->config['system']['main_menu']));
			}
		}

		$this->tpl->assign(array(
			'error' => $this->error
		));

		$this->tpl->display('registration');

	}

	/**
	* Восстановление пароля
	*/
	public function action_forgot() {
	    // Если пользователь уже авторизирован
		if (is_user()) {
			redirect('user/profile');
		}
	
		if (isset($_POST['submit'])) {
			if ($user_info = $this->db->get_row("SELECT * FROM #__users WHERE username = '". a_safe($_POST['username']) ."' OR email = '". a_safe($_POST['email']) ."'")) {
				$pin_code = main::get_unique_code(7);

 				$this->db->query("UPDATE #__users SET
 					pin_code = '". md5(md5($pin_code)) ."',
 					pin_code_time = UNIX_TIMESTAMP()
					WHERE
 					user_id = '". $user_info['user_id'] ."'
 				");

				// Генерация и отправка письма
				$msg = file_get_contents(ROOT .'data_files/email/forgot_message.tpl');

				$msg = str_replace('{USERNAME}', $user_info['username'], $msg);
				$msg = str_replace('{PIN_CODE}', $pin_code, $msg);
				$msg = str_replace('{PIN_CODE_TIME}', $this->config['system']['pin_code_time'], $msg);

				a_import('libraries/email');
				$this->email = new CI_Email;

				$this->email->from($this->config['system']['system_email']);
				$this->email->to($user_info['email']);

				$this->email->subject('Восстановление пароля на '. $this->config['system']['system_title']);
				$this->email->message($msg);

				$this->email->send();

				a_notice('На ваш e-mail адрес выслан временный пароль, временный пароль необходимо сменить в течение '. $this->config['system']['pin_code_time'] .' часов.', a_url('user'));
			}
			else $this->error .= 'Имя пользователя или e-mail адрес не найдены!<br />';
		}

		$this->tpl->assign(array(
			'action' => 'form',
			'error' => $this->error
		));

		$this->tpl->display('forgot');
	}


	/**
	* Смена пароля
	*/
	public function action_change_password() {
		if(ACCESS_LEVEL < 5) a_error('Запрет доступа!');

		if(isset($_POST['submit'])) {
			main::is_demo();
			# Проверка старого пароля
			if(md5(md5($_POST['password'])) != $this->db->get_one("SELECT password FROM #__users WHERE user_id = '". USER_ID ."'")) {
				$this->error .= 'Неверно указан старый пароль!<br />';
			}
			# Проверка нового пароля
			if(!empty($_POST['new_password'])) {
				if(!main::check_input($_POST['new_password'], 'PASSWORD')) {
					$this->error .= 'Неверно указан пароль, формат правильного: '. main::check_input('', 'PASSWORD', 'format') .'<br />';
				}
				if($_POST['new_password'] != $_POST['new_password2']) {
					$this->error .= 'Пароли не совпадают!<br />';
				}
			}

			# Изменяем данные
			if(!$this->error) {
				$this->db->query("UPDATE #__users SET
		 			password = '". md5(md5($_POST['new_password'])) ."'
		 			WHERE
		 			user_id = '". USER_ID ."'
		 		");

				a_notice('Данные успешно изменены!', a_url(MAIN_MENU));
			}
		}

		if(!isset($_POST['submit']) || $this->error) {
			$this->tpl->assign(array(
				'error' => $this->error,
				'success' => $success
			));

			$this->tpl->display('change_password');
		}
	}

	/**
	* Авторизация пользователей
	*/
	public function action_login() {
	    // Если пользователь уже авторизирован
		if (is_user()) {
			redirect('user/profile');
		}
		
		// Авторизация
		if (isset($_POST['submit']) OR ! empty($_GET['username'])) {
		    if (isset($_POST['submit'])) {
                // Фильтрация
				$username = str_safe($_POST['username']);
				$password = $_POST['password'];
			}
			else {
                $username = !empty($_GET['username']) ? $_GET['username'] : '';
				$password = !empty($_GET['password']) ? $_GET['password'] : '';
			}
			
			// Проверка заполнения
			if (empty($username)) $this->error .= 'Не введено имя пользователя<br />';
			if (empty($password)) $this->error .= 'Не введен пароль<br />';
			
			// Проверка наличия пользователя
			if ( ! $user_id = $this->db->get_one("SELECT user_id FROM #__users WHERE username = '". a_safe($username) ."' AND (password = '". md5(md5($password)) ."' OR (pin_code = '". md5(md5($password)) ."' AND pin_code_time > UNIX_TIMESTAMP() - ". intval($this->config['system']['pin_code_time']) ." * 3600))") AND ! $this->error) $this->error .= 'Неверное имя пользователя или пароль<br />';

			if ($user_id AND ! $this->error) {
				// Обновление времени последнего визита
				$this->db->query("UPDATE #__users SET last_visit = UNIX_TIMESTAMP() WHERE user_id = $user_id");
				
				// Авторизация
				$_SESSION['user_id'] = $user_id;
				
				// Удаляем ошибки авторизации
				$_SESSION['login_errors'] = 0;
				
				// "Запоминаем пользователя"
				if (isset($_GET['remember_me'])) {
                    setcookie('username', $username, time() + 60*60*24*365, '/');
					setcookie('password', $password, time() + 60*60*24*365, '/');
				}
				
				// Перенаправление в кабинет
				redirect('user/profile');
			}
		}
		
		// Если есть ошибка создаем запись в сессиях
		if ($this->error) {
			$_SESSION['login_errors']++;
		}
		
		// Форма авторизации
		$this->tpl->assign(array(
			'error' => $this->error
		));

		$this->tpl->display('login');
	}

	/**
	* Список польльзователей
	*/
	public function action_list_users() {
     	# Получение данных
  		$sql = "SELECT SQL_CALC_FOUND_ROWS u.*, up.avatar AS avatar_exists FROM #__users AS u LEFT JOIN #__users_profiles AS up USING(user_id) WHERE user_id != -1 ";

  		switch($_GET['type']) {
  			case 'online':
  				$type = 'online';
  				$sql .= " AND last_visit > UNIX_TIMESTAMP() - 600 ";
  				break;
  			default:
  				$type = 'all';
  				break;
  		}

		$sql .= " ORDER BY rating DESC LIMIT $this->start, $this->per_page";

		$users = $this->db->get_array($sql);
		$total = $this->db->get_one("SELECT FOUND_ROWS()");

		# Пагинация
		$pg_conf['base_url'] = a_url('user/list_users', 'type='. $type .'&amp;start=');
		$pg_conf['total_rows'] = $total;
		$pg_conf['per_page'] = $this->per_page;

		a_import('libraries/pagination');
		$pg = new CI_Pagination($pg_conf);

		$this->tpl->assign(array(
			'users' => $users,
			'type' => $type,
			'total' => $total,
			'pagination' => $pg->create_links()
		));

		$this->tpl->display('list_users');
	}
	
	/**
	* Список польльзователей
	*/
	public function action_list_guests() {
     	# Получение данных
  		$sql = "SELECT SQL_CALC_FOUND_ROWS u.*, up.avatar AS avatar_exists FROM #__users AS u LEFT JOIN #__users_profiles AS up USING(user_id) WHERE user_id != -1 ";

  		switch($_GET['type']) {
  			case 'online':
  				$type = 'online';
  				$sql .= " AND last_visit > UNIX_TIMESTAMP() - 600 ";
  				break;
  			default:
  				$type = 'all';
  				break;
  		}

		$sql .= " ORDER BY rating DESC LIMIT $this->start, $this->per_page";

		$users = $this->db->get_array($sql);
		$total = $this->db->get_one("SELECT FOUND_ROWS()");

		# Пагинация
		$pg_conf['base_url'] = a_url('user/list_users', 'type='. $type .'&amp;start=');
		$pg_conf['total_rows'] = $total;
		$pg_conf['per_page'] = $this->per_page;

		a_import('libraries/pagination');
		$pg = new CI_Pagination($pg_conf);

		$this->tpl->assign(array(
			'users' => $users,
			'type' => $type,
			'total' => $total,
			'pagination' => $pg->create_links()
		));

		$this->tpl->display('list_users');
	}

	/**
	* Выход
	*/
	public function action_exit() {
		$_SESSION = array();
		setcookie("username", "", time() - 3600, '/');
		setcookie("password", "", time() - 3600, '/');
		
		# Уничтожаем сессию
		session_destroy();
		
		unset($user_id);

		a_notice('Вы вышли. До свидания!', URL);
	}

	/**
	* Покинуть панель пользователя и перейти в панель управления
	*/
	public function action_exit_from_user_panel() {
		$_SESSION['check_user_id'] = '';
		a_notice('Переходим в панель управления', a_url('user/admin'), 3);
	}
}
?>