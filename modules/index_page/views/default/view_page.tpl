<?php $this->display('header', array('sub_title' => 'Добро пожаловать!')) ?>

<?php if(!empty($blocks)): ?>
<?php foreach($blocks as $block): ?>
<?php $this->display('title', array('text' => $block['title'])) ?>
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