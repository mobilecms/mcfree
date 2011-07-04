<?php echo $this->display('header', array('sub_title' => 'Подтверждение')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Подтверждение</b></div>

<div class="menu">
<?php echo $message ?><br />
<a href="<?php echo $link_ok ?>">Да</a> | <a href="<?php echo $link_cancel ?>">Нет</a>
</div>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php echo $this->display('footer') ?>