<?php

/**
 * Update from v.2.0 to v.2.1
 *
 * @package
 * @author Platonov Kirill <platonov-kd@ya.ru>
 * @link http://twitter.com/platonov_kd
 */

/**
 * Обновление с v.2.0 до v.2.1
 */

if (!file_exists('./data_files/config.php')) exit('Не найден конфигурационный файл!');
include_once './data_files/config.php';

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS)
  or die ("Could not connect to MySQL");

mysql_select_db (DB_BASE)
  or die ("Could not select database");
  
$errors = array();

mysql_query("SET NAMES utf8");


// Изменения в таблице личных сообщений
mysql_query("ALTER TABLE `a_private_messages` CHANGE `message` `message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");


mysql_query("INSERT INTO a_config SET `module` = 'system', `key` = 'description', `value` = 'MobileCMS - Мобильный движок';");
mysql_query("INSERT INTO a_config SET `module` = 'system', `key` = 'keywords', `value` = 'MobileCMS, MC2, MC';");
mysql_query("INSERT INTO a_config SET `module` = 'system', `key` = 'guestbook_posting', `value` = 'all';");

mysql_query("CREATE TABLE IF NOT EXISTS a_photo_albums (
	`album_id` int(11) NOT NULL auto_increment,
	`user_id` int(11) NOT NULL,
	`name` varchar(30) NOT NULL,
	`about` varchar(3000) NOT NULL,
	PRIMARY KEY  (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		
mysql_query("CREATE TABLE IF NOT EXISTS a_photo (
	`photo_id` int(11) NOT NULL auto_increment,
	`album_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	`name` varchar(30) NOT NULL,
	`about` varchar(3000) NOT NULL,
	`time` int(11) NOT NULL,
	`rating` int(11) default '0',
  `file_ext` varchar(30) NOT NULL, 
	PRIMARY KEY  (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		
mysql_query("INSERT INTO a_config (`id`, `module`, `key` , `value`) VALUES
(NULL , 'photo', 'preview_widht', '150'),
(NULL , 'photo', 'max_widht', '300'),
(NULL , 'photo', 'max_size', '5');");

mysql_query("INSERT INTO `a_modules` (`id`, `name`, `title`, `admin_link`, `description`, `installed`, `status`) VALUES
('', 'photo', 'Фотоальбомы', '', 'Модуль фотоальбомов', 1, 'on')");

@chmod(ROOT .'files/photo', 0777);

echo "Обновление успешно выполнено, удалите файл update.php";

?>