<?php header('Content-Type: application/xhtml+xml; charset=utf-8'); echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?php echo DESCRIPTION ?>" />
		<meta name="keywords" content="<?php echo KEYWORDS ?>" />
		<title><?php echo $GLOBALS['CONFIG']['system']['system_title'] ?> | <?php echo (!empty($title) ? $title : $page['title']) ?></title>
		<link rel="shortcut icon" href="<?php echo URL ?>/views/<?php echo THEME ?>/images/favicon.ico" />
		<link rel="stylesheet" href="<?php echo URL ?>/views/<?php echo THEME ?>/css/default.css" type="text/css" />
	</head>

	<body>
		<div class="head">
			<?php echo HTML::image('logo.png', $GLOBALS['CONFIG']['system']['system_title']) ?>
		</div>

    <div class="auth">
		<?php echo (USER_ID != -1 ? '<a href="'. a_url('user/profile') .'">'. $user['username'] .'</a> <a href="'. a_url('user/exit') .'">Выход</a>' : '<a href="'. a_url('user/login') .'">Вход</a> <a href="'. a_url('user/registration') .'">Регистрация</a>') ?>
    </div>

    <?php echo ads_manager::get_ads_block('all_pages_up', '<div class="adv">', '</div>') ?>

    <?php if (MODERATION_USERS > 0 && ACCESS_LEVEL >= 8): ?>
    <div class="block">
	Модерации <?php echo main::end_str(MODERATION_USERS, 'ждет', 'ждут', 'ждут') ?> <a href="<?php echo a_url('user/admin/moderate') ?>"><?php echo MODERATION_USERS .' '. main::end_str(MODERATION_USERS, 'пользователь', 'пользователя', 'пользователей') ?></a>
	</div>
	<?php endif ?>

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

<?php echo $content ?>

</div>

    <?php echo ads_manager::get_ads_block('all_pages_down', '<div class="adv">', '</div>') ?>

    <div class="copy">
    <?php echo date('Y', time()) ?> &copy; <a href="<?php echo URL ?>"><?php echo $GLOBALS['CONFIG']['system']['system_title'] ?></a> (<a title="Гостей онлайн" href="<?php echo a_url('user/list_guests') ?>"><?php echo GUESTS_ONLINE ?></a>/<a title="Пользователей онлайн" href="<?php echo a_url('user/list_users', 'type=online') ?>"><?php echo USERS_ONLINE ?></a>)
    </div>

    <?php if ( ! empty($GLOBALS['CONFIG']['system']['footer_codes_index']) || ! empty($GLOBALS['CONFIG']['system']['footer_codes_other_pages'])): ?>
    <div class="block">
    <?php if (ROUTE_MODULE == 'index_page') echo $GLOBALS['CONFIG']['system']['footer_codes_index'];
    else echo $GLOBALS['CONFIG']['system']['footer_codes_other_pages'];
    ?>
    </div>
    <?php endif ?>

    <?php if (modules::is_active_module('web_version')): ?>
        <div align="center">
            Версия: <?php echo (WEB_VERSION == '1' ? '<a href="'. URL .'?version=wap">Wap</a> | <u>Web</u>' : '<u>Wap</u> | <a href="'. URL .'?version=web">Web</a>') ?>
        </div>
    <?php endif ?>

    <!-- copyright -->

</body>

</html>

<!--
	Powered by MobileCMS
	http://mobilecms.ru
-->