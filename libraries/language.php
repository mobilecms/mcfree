<?php

/**
 * Класс мультиязычности
 * @author Kirill Platonov <platonov.kd@gmail.com>
 * @link http://uplato.ru
 */

class Language {
	/**
	 * Доступные языки с национальными названиями
	 * @var array
	 */
	public $languages = array();

	/**
	 * Кеширование языковых фраз (в секундах)
	 * @var int
	 */
	public $cache = 0;

	/**
	 * Активный язык
	 * @var string
	 */
	public $language = 'en';

	/**
	 * Массив с фразами языка
	 * @var array
	 */
	public $data = array();

	public function __construct() {
		// Получение массива языков
		$this->get_languages();

		// Определение активного языка
		if ($_SESSION['language']) {
			$this->set_language($_SESSION['language']);
		}
		elseif ($_COOKIE['language']) {
			$this->set_language($_COOKIE['language']);
		}
		else {
			$this->set_language($this->get_browser_language());
		}

		define('LANGUAGE', $this->language);

		// Получение языковых фраз
		$dir = opendir(ROOT .'languages/'. $this->language);

		while ($file = readdir($dir)) {
			if ($file == '.' OR $file == '..' OR $file == 'language.ini' OR $file == '.gitignore') continue;

			$data = include_once ROOT .'/languages/'. $this->language .'/' . $file;

			// Объединение массивов
			$this->data = array_merge($this->data, $data);
		}
	}

	/**
	 * Получение языка браузера
	 * @return string
	 */
	public function get_browser_language() {
		if ( ! $_SERVER['HTTP_ACCEPT_LANGUAGE']) return 'en';

		// Получение языка
		$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

		// Проверка языка
		if ( ! in_array($language, array_keys($this->languages))) {
			$language = 'en';
		}

		return $language;
	}

	/**
	 * Выбор языка
	 * @param string $language
	 */
	public function set_language($language) {
		// Проверка языка
		if ( ! in_array($language, array_keys($this->languages))) {
			$language = $this->get_browser_language();
		}

		// Сохранение данных о выбранном языке для пользователя
		$this->language = $language;

		$_SESSION['language'] = $language;
		setcookie('language', $language, time() + 86400 * 365, '/');
	}

	/**
	 * Получение национального названия языка
	 * @param string $language
	 * @return string
	 */
	public function get_title($language) {
		// Проверка языка
		if ( ! in_array($language, array_keys($this->languages))) {
			$language = $this->get_browser_language();
		}

		return $this->languages[$language];
	}

	/**
	 * Получение строки
	 * @param string $key
	 * @param array $params
	 * @return string
	 */
	public function get_text($key, $params = NULL) {
		if (empty($this->data[$key])) $data = $key;
		else $data = $this->data[$key];

		if (is_numeric($params)) {
			// Замена {n} на заданное значение
			if (strstr($data, '{n}')) $data = str_replace('{n}', $params, $data);

			if (strstr($data, '|')) {
				$str = explode('|', $data);

				switch($this->language) {
					case 'ru':
						$data = main::end_str($params, $str[0], $str[1], $str[2]);
					break;

					default:
						$data = ngettext($str[0], $str[1], $params);
					break;
				}
			}
		}
		elseif (is_array($params)) {
			// Заменяем переменные их значением
			foreach($params AS $key => $value) {
				if (strstr($data, '{'. $key .'}')) $data = str_replace('{'. $key .'}', $value, $data);
			}
		}

		return $data;
	}

	/**
	 * Получение массива доступных языков
	 */
	protected function get_languages() {
		// Перебор файлов конфигурации языковых пакетов
		$dir = opendir(ROOT .'languages');

		while ($lang = readdir($dir)) {
			// Проверка наличия файла конфигурации
			if ( ! file_exists(ROOT .'languages/'. $lang .'/language.ini')) continue;

			// Запись конфигурационных данных в массив
			$config = parse_ini_file(ROOT .'languages/'. $lang .'/language.ini');

			if (empty($config['name'])) continue;

			$this->languages = array_merge($this->languages, array($lang => $config['name']));
		}
	}
}

?>
