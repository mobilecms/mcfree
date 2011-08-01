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
 * Класс для работы с j2me
 */
class j2me_tools {
	/**
	* Генерация jad из jar
	*/
	public static function get_jad($jar_path, $jar_url) {
		if(!class_exists('PclZip')) a_import('libraries/pclzip.lib');
		if(!file_exists($jar_path)) a_error('JAR файл не найден!');

		$zip = new PclZip($jar_path);

		$manifest_arr = $zip->extract(PCLZIP_OPT_BY_NAME, 'META-INF/MANIFEST.MF', PCLZIP_OPT_EXTRACT_AS_STRING);
		if(!$manifest = $manifest_arr[0]['content']) a_error('Manifest не найден!');

		$jar_filesize = filesize($jar_path);

		$midlet_jar_size  = sprintf("MIDlet-Jar-Size: %d", $jar_filesize);
	 	$midlet_jar_url   = sprintf("MIDlet-Jar-URL: %s", $jar_url);
	  	$jad_content = sprintf("%s\n%s\n%s\n", trim($manifest), $midlet_jar_size, $midlet_jar_url);

		return $jad_content;
	}
}
?>