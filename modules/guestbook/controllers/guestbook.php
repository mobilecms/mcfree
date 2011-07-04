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
 * Котроллер гостевой книги
 */
class Guestbook_Controller extends Controller {
	/**
	* Уровень пользовательского доступа
	*/
	public $access_level = 0;

	/**
	* Метод по умолчанию
	*/
	public function action_index() {
		$this->action_list_messages();
	}

	/**
	* Листинг сообщений
	*/
	public function action_list_messages() {
		$_config = $this->config['system'];
		
		# Получение данных
  		$result = $this->db->query("SELECT SQL_CALC_FOUND_ROWS #__guestbook.*, #__users.status AS user_status, up.avatar AS avatar_exists, #__users.last_visit
  			FROM #__guestbook LEFT JOIN #__users USING(user_id) LEFT JOIN #__users_profiles AS up USING(user_id)
  			ORDER BY message_id DESC LIMIT $this->start, $this->per_page");

  		$total = $this->db->get_one("SELECT FOUND_ROWS()");

		if(!class_exists('smiles')) a_import('modules/smiles/helpers/smiles');
		$comments = array();
  		while($message = $this->db->fetch_array($result)) {
			# Форматируем текст сообщения
			$message['message'] = smiles::smiles_replace($message['message']);
			$message['message'] = main::bbcode($message['message']);
			$message['message'] = nl2br($message['message']);

			$messages[] = $message;
  		}

		# Пагинация
		$pg_conf['base_url'] = a_url('guestbook', 'start=');
		$pg_conf['total_rows'] = $total;
		$pg_conf['per_page'] = $this->per_page;

		a_import('libraries/pagination');
		$pg = new CI_Pagination($pg_conf);

		$this->tpl->assign(array(
		  '_config' => $_config,
			'messages' => $messages,
			'total' => $total,
			'pagination' => $pg->create_links()
		));

		$this->tpl->display('list_messages');
	}

	/**
	* Написать сообщение
	*/
	public function action_say() {
	 $_config = $this->config['system'];
	 
		if(isset($_POST['submit'])) {
			if(empty($_POST['username'])) {
				$this->error .= 'Укажите ваше имя<br />';
			}
			if($check_user_id = $this->db->get_one("SELECT user_id FROM #__users WHERE username = '". a_safe($_POST['username']) ."'")) {
				if(USER_ID != $check_user_id) {
					$this->error .= 'Данное имя занято на сайте, укажите другое или авторизуйтесь, если вы не вошли в систему<br />';
				}
			}
			if ($_config['guestbook_posting'] == 'users' && USER_ID == -1) {
        $this->error .= 'Для написания сообщений вам необходимо авторизироваться на сайте<br />';
      }
			if(empty($_POST['message'])) {
				$this->error .= 'Укажите сообщение<br />';
			}
			if(!main::check_input($_POST['username'], 'LOGIN')) {
				$this->error .= 'Неверно указано имя пользователя, формат правильного: '. main::check_input('', 'LOGIN', 'format') .'<br />';
			}
            
			# Проверка кода с картинки
			if(USER_ID == -1) {
				if($_POST['captcha_code'] != $_SESSION['captcha_code']) {
					$this->error .= 'Неверно указан код с картинки<br />';
				}
			}

			if(!$this->error) {
				a_antiflud();

				setcookie('username', $_POST['username'], time() + 999999999, '/');

				$this->db->query("INSERT INTO #__guestbook SET
					username = '". a_safe($_POST['username']) ."',
					user_id = '". USER_ID ."',
					message = '". a_safe($_POST['message']) ."',
					time = UNIX_TIMESTAMP()
				");

				$_SESSION['captcha_code'] = main::get_unique_code(4);

				user::rating_update();

				header("Location: ". a_url('guestbook', '', true));
				exit;
			}
		}
		if(!isset($_POST['submit']) OR $this->error) {
			$_SESSION['captcha_code'] = main::get_unique_code(4);

			$this->tpl->assign(array(
				'error' => $this->error
			));

			$this->tpl->display('say');
		}
	}

	/**
	* Удаление сообщения
	*/
	public function action_delete_message() {
		if(!$message = $this->db->get_row("SELECT #__guestbook.*, #__users.status AS user_status FROM #__guestbook LEFT JOIN #__users USING(user_id) WHERE message_id = '". intval($_GET['message_id']) ."'"))
			a_error('Сообщение не найдено!');

		if(!a_check_rights($message['user_id'], $message['user_status'])) a_error('У вас нет прав на выполнение этой операции!');

		if(!empty($_GET['confirm'])) {
			$this->db->query("DELETE FROM #__guestbook WHERE message_id = '". intval($_GET['message_id']) ."'");
			user::rating_update(-1, $message['user_id']);
			a_notice('Сообщение удалено!', a_url('guestbook'));
		}
		else {
			a_confirm('Подтверждаете удаление данного сообщения?', a_url('guestbook/delete_message', 'message_id='. $_GET['message_id'] .'&amp;confirm=ok'), a_url('guestbook'));
		}
	}
}
?>