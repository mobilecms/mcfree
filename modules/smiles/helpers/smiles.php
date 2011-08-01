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
 * Хелпер смайлов
 */
class smiles {
	/**
	* Добавление смайлов в сообщение
	*/
	public static function smiles_replace($string) {
		$smiles_array = unserialize(file_get_contents(ROOT .'data_files/smiles.dat'));
 		$string = strtr($string, $smiles_array);
 		$string = str_replace('{%URL%}', URL, $string);
		return $string;
	}

	/**
	* Обновление смайлов
	*/
	public static function smiles_update(&$db) {
		$result = $db->query("SELECT * FROM #__smiles WHERE status = 'enable'");
		while($smile = $db->fetch_array($result)) {
			$smiles_array[$smile['code']] = '<img src="{%URL%}modules/smiles/smiles/'. $smile['image'] .'" alt="'. $smile['code'] .'" />';
		}

		$fp = fopen (ROOT . 'data_files/smiles.dat', 'w+');
 		fwrite ($fp, serialize($smiles_array));
 		fclose ($fp);
	}
}
?>