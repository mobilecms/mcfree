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

/**
* Контроллер управления пользователями
*/
class User_Admin_Controller extends Controller {
	/**
	* Уровень пользовательского доступа
	*/
	protected $access_level = 8;
	/**
	* Тема
	*/
	protected $template_theme = 'admin';

	/**
	* Метод по умолчанию
	*/
	public function action_index() {
		$this->action_list_users();
	}
	
	/**
	* Конфигурация модуля
	*/
	public function action_config() {
		$_config = $this->config['user'];

		if (isset($_POST['submit'])) {
			main::is_demo();
			$_config = $_POST;

			main::config($_config, 'user', $this->db);

			a_notice('Настройки модуля успешно изменены!', a_url('user/admin/config'));
		}
		
		$this->tpl->assign(array(
			'_config' => $_config
		));

		$this->tpl->display('config');
	}

	/**
	* Удаление пользователя
	*/
	public function action_delete() {
		main::is_demo();
		# Получаем инфо о пользователе
		if(!$user_delete = $this->db->get_row("SELECT * FROM #__users WHERE user_id = '". intval($_GET['user_id']) ."'"))
			a_error("Пользователь не найден!");

		$user_delete_access = $this->access->get_level($user_delete['status']);

		if(ACCESS_LEVEL <= $user_delete_access) a_error("У вас нет прав на выполнение этой операции!");
		else {
			$this->db->query("DELETE FROM #__users WHERE user_id = ". intval($user_delete['user_id']));
			a_notice('Пользователь удален!', a_url('user/admin'));
		}
	}

	/**
	* Бан пользователя
	*/
	public function action_ban() {
		# Получаем инфо о пользователе
		if(!$user_ban = $this->db->get_row("SELECT * FROM #__users WHERE user_id = '". intval($_GET['user_id']) ."'"))
			a_error("Пользователь не найден!");

		$user_ban_access = $this->access->get_level($user_ban['status']);

		if(ACCESS_LEVEL <= $user_ban_access) a_error("У вас нет прав на выполнение этой операции!");

		if(isset($_POST['submit'])) {
			main::is_demo();
			if(!is_numeric($_POST['hours'])) {
				$this->error .= 'Неверный формат времени - только целые числа.<br />';
			}
			if(empty($_POST['description'])) {
				$this->error .= 'Укажите причину бана.<br />';
			}

			if(!$this->error) {
				$this->db->query("INSERT INTO #__users_ban SET
		   			user_id = '". intval($_GET['user_id']) ."',
		   			to_time = '". ($_POST['hours'] * 3600 + time()) ."',
		   			description = '". a_safe($_POST['description']) ."'
		   		");
				a_notice('Пользователь забанен.', a_url('user/admin'));
			}
		}
		
		if (isset($_POST['delete_ban'])) {
               main::is_demo();
               $this->db->query("DELETE FROM #__users_ban WHERE user_id = '". intval($_GET['user_id']) ."'");
               a_notice('Пользователь разбанен.', a_url('user/admin'));
		}
		
		# Получаем информацию о текущем бане
		$this->ban = $this->db->get_row("SELECT * FROM #__users_ban WHERE user_id = '". intval($_GET['user_id']) ."' AND status = 'enable'");

		if(!isset($_POST['submit']) || $this->error) {
			$this->tpl->assign(array(
				'error' => $this->error,
				'ban'   => $this->ban,
				'username_ban' => $user_ban['username']
			));

			$this->tpl->display('ban');
		}
	}


	/**
	* Редактирование пользователя
	*/
	public function action_edit() {
		# Получаем инфо о пользователе
		if(!$user_edit = $this->db->get_row("SELECT * FROM #__users WHERE user_id = '". intval($_GET['user_id']) ."'"))
			a_error("Пользователь не найден!");

		$user_edit_access = $this->access->get_level($user_edit['status']);

		if(ACCESS_LEVEL <= $user_edit_access) a_error("У вас нет прав на выполнение этой операции!");

		if(isset($_POST['submit'])) {
			main::is_demo();
			if(!main::check_input($_POST['email'], 'MAIL')) {
				$this->error .= 'Неверный формат e-mail.<br />';
			}
			if($_POST['status'] != 'admin' && $_POST['status'] != 'moder' && $_POST['status'] != 'user') {
				$this->error .= 'Укажите валидный статус!<br />';
			}
			if(ACCESS_LEVEL < 10 && $_POST['status'] != $user_edit['status']) {
				$this->error .= 'Только администратор может менять статусы пользователей!<br />';
			}

			if(!$this->error) {
				$this->db->query("UPDATE #__users SET
		 			email = '". a_safe($_POST['email']) ."',
		 			status = '". a_safe($_POST['status']) ."'
		 			WHERE user_id = '". intval($_GET['user_id']) ."'
		 		");

				a_notice('Пользователь изменен!', a_url('user/admin'));
			}
		}
		if(!isset($_POST['submit']) || $this->error) {
			$this->tpl->assign(array(
				'error' => $this->error,
				'user_edit' => $user_edit
			));

			$this->tpl->display('edit');
		}
	}

	/**
	* Вход в панель к пользователю
	*/
	public function action_go_to_user_panel() {
		if(!$check_user = $this->db->get_row("SELECT * FROM #__users WHERE user_id = '". intval($_GET['user_id']) ."'"))
			a_error('Пользователь не найден!');
	
		if(!a_check_rights($check_user['user_id'], $check_user['status']))
			a_error('У вас нет прав на выполнение этого действия!');
	
		$_SESSION['check_user_id'] = intval($_GET['user_id']);
	
		header('Location: '. a_url(MAIN_MENU));
	}

	/**
	* Листинг пользователей
	*/
	public function action_list_users() {
	    // Кол-во пользователей на страницу
		$this->per_page = $this->config['user']['user_per_page_panel'];

		// Получение данных
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM #__users
			WHERE 1 = 1 AND user_id > 0 ";
			
		if (!empty($_GET['user_id'])) $sql .= " AND user_id = ". intval($_GET['user_id']);
		else {
			if (!empty($_GET['username'])) $sql .= " AND username LIKE '%". a_safe($_GET['username']) ."%'";
			if (!empty($_GET['status'])) $sql .= " AND status = '". a_safe($_GET['status']) ."'";
		}
		
		if (str_safe($_GET['type']) == 'online') $sql .= " AND last_visit > UNIX_TIMESTAMP() - 600 ";
		
		$sql .= " ORDER BY user_id ". ($_GET['sort'] == 'desc' ? 'DESC' : 'ASC') ." LIMIT $this->start, $this->per_page";

		$users = $this->db->get_array($sql);
		$total = $this->db->get_one("SELECT FOUND_ROWS()");

		// Пагинация
		$pg_conf['base_url'] = a_url('user/admin/list_users', 'status='. str_safe($_GET['status']) .'&amp;login='. str_safe($_GET['username']) .'&amp;user_id='. intval($_GET['user_id']) .'&amp;sort='. str_safe($_GET['sort']) .'&amp;start=');
		$pg_conf['total_rows'] = $total;
		$pg_conf['per_page'] = $this->per_page;

		a_import('libraries/pagination');
		$pg = new CI_Pagination($pg_conf);

		$this->tpl->assign(array(
			'users' => $users,
			'total' => $total,
			'db'    => $this->db,
			'start' => $this->start,
			'pagination' => $pg->create_links(),
			'action' => 'list'
		));

		$this->tpl->display('list_users');
	}
	
	/**
	* Листинг гостей
	*/
	public function action_list_guests() {
	    // Кол-во пользователей на страницу
		$this->per_page = $this->config['user']['user_per_page_panel'];

		// Получение данных
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM #__guest
			WHERE 1 = 1 AND last_time > UNIX_TIMESTAMP() - 600
		ORDER BY last_time DESC LIMIT $this->start, $this->per_page";

		$guests = $this->db->get_array($sql);
		$total = $this->db->get_one("SELECT FOUND_ROWS()");

		// Пагинация
		$pg_conf['base_url'] = a_url('user/admin/list_guests', 'start=');
		$pg_conf['total_rows'] = $total;
		$pg_conf['per_page'] = $this->per_page;

		a_import('libraries/pagination');
		$pg = new CI_Pagination($pg_conf);

		$this->tpl->assign(array(
			'guests' => $guests,
			'total' => $total,
			'db'    => $this->db,
			'start' => $this->start,
			'pagination' => $pg->create_links()
		));

		$this->tpl->display('list_guests');
	}
}
?>