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
 
defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа!</b>');

/**
 * Хелпер установки модуля
 */
class comments_installer {
    /**
     * Установка модуля
     */
    public static function install(&$db) {
        $db->query("CREATE TABLE IF NOT EXISTS #__comments_posts ( 
              `comment_id` int(11) NOT NULL auto_increment, 
              `module` varchar(30) NOT NULL, 
              `item_id` int(11) NOT NULL, 
              `user_id` int(11) NOT NULL, 
              `username` varchar(50) NOT NULL, 
              `text` varchar(300) NOT NULL, 
              `time` int(11) NOT NULL, 
              PRIMARY KEY  (`comment_id`), 
              KEY `item_id` (`item_id`) 
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8; 
        ");
        
        $db->query("INSERT INTO #__config SET `module` = 'system', `key` = 'comments_posting', `value` = 'all'; 
        ");
    }
    
    /**
     * Деинсталляция модуля
     */
    public static function uninstall(&$db) {
        $db->query("DROP TABLE #__comments_posts;");
        $db->query("DELETE FROM #__config WHERE `key` = 'comments_posting';");
    }
}

?>