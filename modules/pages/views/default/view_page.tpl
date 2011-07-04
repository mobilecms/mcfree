<?php $this->display('header.tpl', array('title' => $page['title'])) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b><?php echo $page['title'] ?></b></div>

<div class="menu">
<?php echo $page['content'] ?>
</div>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>