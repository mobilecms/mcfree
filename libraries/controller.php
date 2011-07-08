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

//----------------------------------------

/**
 * Controller class
 *
 * @author Ant0ha
 */
abstract class Controller {
	/**
	* Переменная, в которую записываем ошибки при валидации форм
	*/
	public $error = false;
	/**
	* Класс шаблонизатора
	*/
	public $tpl;
	/**
	* Тип шаблонизатора
	*/
	protected $template_type = 'template';
	/**
	* Тема
	*/
	protected $template_theme = 'default';
	/**
	* Количество элементов на страницу по умолчанию
	*/
	protected $per_page = 7;

	/**
	* Constructor
	*/
	public function __construct() {
		$this->config = Registry::get('config');
		$this->db = Registry::get('db');

		# Определение старта для пагинации
		$this->start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
		$this->start = is_numeric($_GET['page']) ? $_GET['page'] * $this->per_page - 1 : $this->start;
		if($this->start < 0) a_error('Не верный формат данных');

		switch($this->template_type) {
			# Смарти
			case  'smarty':
				a_import('libraries/smarty');
				$this->tpl = new MY_Smarty;
				$this->tpl->compile_dir = ROOT .'cache/smarty_templates/';
				break;

			# Native php
			case 'template':
				a_import('libraries/template');
				$this->tpl = new Template;
				break;

			# Если шаблонизатор не определен
			default:
				a_error('Укажите тип шаблонизатора!');
		}
		
		# Добавляем объект шаблона в Registry
		Registry::set('tpl', $this->tpl);

		if($this->template_theme == 'admin') {
			$this->template_theme = $this->config['system']['admin_theme'];
		}
		else {
			$this->template_theme = $this->config['system']['default_theme'];
		}
		
		# Добавление мета данных на страницу
		if (!empty($this->config['system']['description'])) $this->tpl->description = $this->config['system']['description'];
		if (!empty($this->config['system']['keywords'])) $this->tpl->keywords = $this->config['system']['keywords'];
		
		# Подключение кеширования
		if(!class_exists('File_Cache')) a_import('libraries/file_cache');
  		$this->cache = new File_Cache(ROOT .'cache/file_cache');

		# Получение данных о польльзователе
		if(!empty($_SESSION['check_user_id'])) $user_id = $_SESSION['check_user_id'];
		elseif(!empty($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
		else $user_id = -1;

		# Если пользователь - гость, проверяем его куки и если необходимо, авторизуем
		if($user_id == -1 && !empty($_COOKIE['username'])) {
			if($try_user_id = $this->db->get_one("SELECT user_id FROM #__users WHERE username = '". a_safe($_COOKIE['username']) ."' AND password = '". md5(md5($_COOKIE['password'])) ."'")) {
				$user_id = $try_user_id;
				$_SESSION['user_id'] = $user_id;
			}
		}

		$this->user = $this->db->get_row("SELECT * FROM #__users LEFT JOIN #__users_profiles USING(user_id) WHERE user_id = $user_id");

		define('USER_ID', $this->user['user_id']);
		$this->tpl->assign('user', $this->user);
		
		// Собираем информацию о госте
		if (USER_ID == -1) {
		    $ua = explode('(', $_SERVER['HTTP_USER_AGENT']);

            // Проверяем наличие пользователя в списке
			if ($guest = $this->db->get_row("SELECT * FROM #__guest WHERE ip = '". a_safe($_SERVER['REMOTE_ADDR']) ."' AND ua = '". a_safe($ua[0]) ."'")) {
				// Обновляем дату последнего посещения
                $this->db->query("UPDATE #__guest SET
                	last_time = UNIX_TIMESTAMP()
              		WHERE id = '". $guest['id'] ."'
              	");
			}
			else {
				// Записываем пользователя в базу
                $this->db->query("INSERT INTO #__guest SET
                    ip = '". a_safe($_SERVER['REMOTE_ADDR']) ."',
                    ua = '". a_safe($ua[0]) ."',
                	last_time = UNIX_TIMESTAMP()
              	");
			}
		}

		# Обновляем время последнего посещения
		if(USER_ID != -1) $this->db->query("UPDATE #__users SET last_visit = UNIX_TIMESTAMP() WHERE user_id = '". USER_ID ."'");

		# helper модуля пользователей
		a_import('modules/user/helpers/user');

		# Управление правами доступа
		$this->access = a_load_class('libraries/access');

		if($this->user) $access_level = $this->access->get_level($this->user['status']);
		else $access_level = 1;

		define('ACCESS_LEVEL', $access_level);

		if(ACCESS_LEVEL < $this->access_level) {
			if(USER_ID == -1) {
				header('Location: '. a_url('user/login', 'from='. urlencode($_SERVER["REQUEST_URI"]) , true));
				exit;
			}
			else {
				a_error('У вас нет доступа к данной странице!');
			}
		}

		# Выполнение событий до вызова контроллера
		main::events_exec(&$this->db, 'pre_controller');
		
		# Включение web темы
		if (WEB_VERSION == '1' && $this->template_theme != 'admin') {
      $this->tpl->theme = $this->config['system']['web_theme'];
      define('THEME', $this->config['system']['web_theme']);
    }
		else {
		  $this->tpl->theme = $this->template_theme;
      define('THEME', $this->tpl->theme);
    }
	}
}
?>