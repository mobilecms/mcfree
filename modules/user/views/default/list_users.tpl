<?php $this->display('header.tpl', array('sub_title' => 'Пользователи')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Пользователи</b></div>
<div class="block">
<?php if($type == 'all'): ?><span style="color: black;"><u>Все</u></span><?php else: ?><a href="<?php echo a_url('user/list_users') ?>">Все</a><?php endif; ?> |
<?php if($type == 'online'): ?><span style="color: black;"><u>Онлайн</u></span><?php else: ?><a href="<?php echo a_url('user/list_users', 'type=online') ?>">Онлайн</a><?php endif; ?>
</div>

<?php if(!empty($users)): ?>
	<?php foreach($users as $user): ?>
	<div class="menu">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td><?php if($user['avatar_exists']) echo '<img src="'. URL .'files/avatars/'. $user['user_id'] .'_32.jpg" alt="" />'; else echo '<img src="'. URL .'files/avatars/empty_32.png" alt="" />'; ?>&#160;</td>
			<td>
				<b><a href="<?php echo a_url('user/profile/view', 'user_id='. $user['user_id']) ?>"><?php echo $user['username'] ?></a></b> [<?php echo a_is_online($user['last_visit']) ?>]<br />
				<span style="color: grey; font-size: 11px;">[<?php echo $GLOBALS['controller']->access->ru_roles[$user['status']] ?>]</span>
			</td>
		</tr>
	</table>
	<?php echo $message['message'] ?>
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block">
	<p>Пользователей нет</p>
	</div>
<?php endif; ?>

<?php if($pagination)
	echo '<div class="block">'. $pagination .'</div>';
?>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>