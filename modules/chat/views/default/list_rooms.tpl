<?php $this->display('header', array('title' => 'Чат | Прихожая')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" />Чат | Прихожая</div>

<?php if(!empty($rooms)): ?>
    <?php foreach($rooms as $room): ?>
	<div class="menu">
		<img src="<?php echo URL ?>views/<?php echo THEME ?>/img/icon.png" alt="" /> <a href="<?php echo a_url('chat/in_room', 'room_id='. $room['room_id']) ?>"><?php echo $room['name'] ?></a> <span class="small_text">[<?php echo $room['users_in_room'] ?>]</span><br />
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block"><p>Комнат нет...</p></div>
<?php endif; ?>

<div class="block">
<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>