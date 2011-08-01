<?php header('Content-Type: application/xhtml+xml; charset=utf-8'); echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php  echo $GLOBALS['CONFIG']['system']['system_title']  ?> | <?php echo (!empty($title) ? $title : $sub_title) ?></title>
<link rel="shortcut icon" href="/views/<?php echo THEME ?>/img/favicon.ico" />
<link rel="stylesheet" href="/views/<?php echo THEME ?>/style.css" type="text/css" />
</head>

<body>
<div class="head"><img src="/views/<?php echo THEME ?>/img/logo.png" alt="" /></div>

<?php if (ROUTE_MODULE != 'user'): ?>
<div class="auth">
<?php if(USER_ID == -1): ?>
<a href="<?php echo a_url('user/login') ?>">Вход</a> <a href="<?php echo a_url('user/registration') ?>">Регистрация</a>
<?php else: ?>
<a href="<?php echo a_url('user/profile') ?>"><?php echo $user['username'] ?></a> <a href="<?php echo a_url('user/exit') ?>">Выход</a>
<?php endif ?>
</div>
<?php endif ?>

<?php echo ads_manager::get_ads_block('all_pages_up', '<div class="adv">', '</div>') ?>

<?php if (defined('PRIVATE_NEW_MESSAGES')): ?>
<div class="block">
<a href="<?php echo a_url('private/list_messages', 'folder=new') ?>"><?php echo PRIVATE_NEW_MESSAGES .' '. main::end_str(PRIVATE_NEW_MESSAGES, 'новое сообщение', 'новых сообщения', 'новых сообщений') ?></a>
</div>
<?php endif ?>

<?php if (!empty($_SESSION['check_user_id'])): ?>
<div class="block">
<a href="<?php echo a_url('user/exit_from_user_panel') ?>">Покинуть панель пользователя <b><?php echo $user['username'] ?></b> и перейти в панель управления</a>
</div>
<?php endif ?>

<div class="main">