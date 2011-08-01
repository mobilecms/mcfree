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
 * Хелпер модуля комментариев
 */
class comments {
    /**
     * Получение количества комментов
     */
    public static function get_count_comments($db, $module, $item_id) {
        $count = $db->get_one("SELECT COUNT(*) FROM #__comments_posts WHERE
            module = '" . a_safe($module) . "' AND
            item_id = '" . intval($item_id) . "'
        ");
        
        return $count;
    }
}

?>