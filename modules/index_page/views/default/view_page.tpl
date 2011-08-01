<?php $this->display('header', array('sub_title' => 'Добро пожаловать!')) ?>

<?php if(!empty($blocks)): ?>
<?php foreach($blocks as $block): ?>
<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b><?php echo $block['title'] ?></b></div>
	<?php if(!empty($block['widgets'])): ?>
	<div class="menu">
		<?php foreach($block['widgets'] as $widget): ?>
        <?php echo $widget ?>
        <?php endforeach; ?>
	</div>
	<?php endif; ?>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block">
	<b>Блоков нет</b>
	</div>
<?php endif; ?>

<?php $this->display('footer') ?>