<?php

class HTML {
	/**
	 * Вывод изображения из тем оформления
	 *
	 * При попытки вывод сначала проверяется наличие изображения в папке с
	 * темой, затем проверяется папка с общими для тем изображениями
	 * @param string $name
	 * @param string $description
	 * @param array $params
	 * @return mixed
	 */
    public static function image($name, $description = NULL, $params = array()) {
		if (file_exists(ROOT .'themes/'. THEME .'/images/'. $name)) {
			return '<img src="'. URL .'themes/'. THEME .'/images/'. $name .'" alt="'. $description .'" />';
		}
		elseif (file_exists(ROOT .'images/themes/'. $name)) {
			return '<img src="'. URL .'images/themes/'. $name .'" alt="'. $description .'" />';
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Генерация ссылки
	 * @param string $url
	 * @param string $name
	 * @param array $params
	 * @return string
	 */
	public static function link($url, $name = NULL, $params = array()) {
		// Обработка дополнительных параметров
		if ( ! empty($params)) {
			$link_params = '';

			// Заголовок
			if ( ! empty($params['title'])) $link_params .= ' title="'. $params['title'] .'"';

			// ID ссылки
			if ( ! empty($params['id'])) $link_params .= ' id="'. $params['id'] .'"';

			// Определение окна на которое указывает ссылка
			if ( ! empty($params['target'])) $link_params .= ' target="'. $params['target'] .'"';
		}
		else {
			$link_params = '';
		}

		return '<a'. $link_params .' href="'. $url .'">'. ($name != NULL ? $name : $url) .'</a>';
	}
}

?>