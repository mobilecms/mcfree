<?php $this->display('header', array('sub_title' => 'Вы забанены!')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Вы забанены!</b></div>

<div class="block">
Причина бана: <?php echo (!empty($ban['description']) ? $ban['description'] : 'не указана') ?><br />
До окончания бана осталось: <?php echo date('H:i:s', $ban['to_time']) ?>
</div>

<?php $this->display('footer') ?>