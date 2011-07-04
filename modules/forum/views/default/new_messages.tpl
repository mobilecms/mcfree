<?php $this->display('header', array('title' => 'Новые сообщения')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" />Новые сообщения</div>

<?php if($messages): ?>
    <?php foreach($messages as $message): ?>
	<div class="menu">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td><?php if($message['avatar_exists']) echo '<img src="'. URL .'files/avatars/'. $message['user_id'] .'_32.jpg" alt="" />'; else echo '<img src="'. URL .'files/avatars/empty_32.png" alt="" />'; ?>&#160;</td>
			<td>
				<b><a href="<?php echo a_url('user/profile/view', 'user_id='. $message['user_id']) ?>"><?php echo $message['username'] ?></a></b> [<?php echo a_is_online($message['last_visit']) ?>] <?php if(a_check_rights($message['user_id'], $message['user_status'])): ?>[<a href="<?php echo a_url('forum/posting', 'message_id='. $message['message_id']) ?>">изм</a>]<?php if($message['is_last_message']): ?>[<a href="<?php echo a_url('forum/message_delete', 'message_id='. $message['message_id'] .'&amp;start='. @$_GET['start']) ?>">уд</a>]<?php endif; endif; ?><br />
				<span class="small_text">[<?php echo date('d.m.Y в H:i', $message['time']) ?>]</span>
			</td>
		</tr>
	</table>
    <?php echo $message['message'] ?><hr />
    в теме: <a href="<?php echo a_url('forum/viewtopic', 'topic_id='. $message['topic_id'] .'&amp;start='. (floor($message['all_messages'] / $messages_per_page) * $messages_per_page)) ?>"><?php echo $message['topic_name'] ?></a>
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
<a href="<?php echo a_url('forum') ?>">Форум</a><br />
<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>