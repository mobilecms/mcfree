<?php $this->display('header.tpl', array('sub_title' => 'Гостевая книга')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Гостевая книга</b></div>
<div class="block">
<?php if ($_config['guestbook_posting'] != 'users' || USER_ID != -1): ?><a href="<?php echo a_url('guestbook/say') ?>">Написать</a><br /><?php endif; ?>
<a href="<?php echo a_url('guestbook', 'rand='. rand(111, 999)) ?>">Обновить</a>
</div>

<?php if(!empty($messages)): ?>
	<?php foreach($messages as $message): ?>
	<div class="menu">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td><?php if($message['avatar_exists']) echo '<img src="'. URL .'files/avatars/'. $message['user_id'] .'_32.jpg" alt="" />'; else echo '<img src="'. URL .'files/avatars/empty_32.png" alt="" />'; ?>&#160;</td>
			<td>
				<b><a href="<?php echo a_url('user/profile/view', 'user_id='. $message['user_id']) ?>"><?php echo $message['username'] ?></a></b> [<?php echo a_is_online($message['last_visit']) ?>] <?php if(a_check_rights($message['user_id'], $message['user_status'])): ?>[<a href="<?php echo a_url('guestbook/delete_message', 'message_id='. $message['message_id']) ?>">x</a>]<?php endif; ?><br />
				<span style="color: grey; font-size: 11px;">[<?php echo date('d.m.Y в H:i', $message['time']) ?>]</span>
			</td>
		</tr>
	</table>
	<?php echo $message['message'] ?>
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block">
	<p>Сообщений нет</p>
	</div>
<?php endif; ?>

<?php if($pagination)
	echo '<div class="block">'. $pagination .'</div>';
?>

<div class="block">
<?php if ($_config['guestbook_posting'] != 'users' || USER_ID != -1): ?><a href="<?php echo a_url('guestbook/say') ?>">Написать</a><br /><?php endif; ?>
<a href="<?php echo a_url('guestbook', 'rand='. rand(111, 999)) ?>">Обновить</a>
</div>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>