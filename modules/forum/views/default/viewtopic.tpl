<?php $this->display('header', array('title' => $topic['name'])) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><a href="<?php echo a_url('forum/viewforum', 'forum_id='. $forum['forum_id']) ?>"><?php echo $forum['name'] ?></a> | <?php echo $topic['name'] ?></div>

<?php if($messages): ?>
    <?php foreach($messages as $message): ?>
	<div class="menu">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td><?php if($message['avatar_exists']) echo '<img src="'. URL .'files/avatars/'. $message['user_id'] .'_32.jpg" alt="" />'; else echo '<img src="'. URL .'files/avatars/empty_32.png" alt="" />'; ?>&#160;</td>
			<td>
				<b><a href="<?php echo a_url('user/profile/view', 'user_id='. $message['user_id']) ?>"><?php echo $message['username'] ?></a></b> [<?php echo a_is_online($message['last_visit']) ?>] [<a href="<?php echo a_url('forum/posting', 'topic_id='. $topic['topic_id'] .'&amp;replay='. $message['username']) ?>">отв</a>][<a href="<?php echo a_url('forum/posting', 'topic_id='. $topic['topic_id'] .'&amp;q='. $message['message_id']) ?>">цит</a>]<?php if(a_check_rights($message['user_id'], $message['user_status'])): ?>[<a href="<?php echo a_url('forum/posting', 'message_id='. $message['message_id']) ?>">изм</a>]<?php if($message['is_last_message']): ?>[<a href="<?php echo a_url('forum/message_delete', 'message_id='. $message['message_id'] .'&amp;start='. @$_GET['start']) ?>">уд</a>]<?php endif; endif; ?><br />
				<span class="small_text">[<?php echo date('d.m.Y в H:i', $message['time']) ?>]</span>
			</td>
		</tr>
	</table>
    <?php echo $message['message'] ?>
    
    <?php if(!empty($message['file_name'])): ?>
    <hr />
    <img src="<?php echo URL ?>modules/forum/views/default/img/attach.png" alt="" /> <a href="<?php echo a_url('forum/download_attach', 'file_id='. $message['file_id']) ?>"><?php echo $message['file_name'] ?></a> (<?php echo main::byte_format($message['file_size']) ?>)<br />
    <span class="small_text">Скачиваний: <?php echo $message['file_downloads'] ?></span>
    <?php endif; ?>
    
    <?php if($message['edit_count'] > 0) echo '<br />________<br /><span class="small_text" style="font-size: 10px">посл. ред. '. date('d.m.Y в H:i', $message['edit_time']) .'; всего '. $message['edit_count'] .' раз(а); by '. $message['edit_editor'] .'</span>'; ?>
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block">
	<p>В данной теме нет сообщений</p>
	</div>
<?php endif; ?>

<?php if($pagination)
	echo '<div class="block">'. $pagination .'</div>';
?>

<div class="block">
<a href="<?php echo a_url('forum/posting', 'topic_id='. $topic['topic_id']) ?>">Ответить на тему</a><br />
</div>

<div class="block">
<a href="<?php echo a_url('forum') ?>">Форум</a><br />
<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>