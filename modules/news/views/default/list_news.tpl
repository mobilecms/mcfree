<?php $this->display('header.tpl', array('sub_title' => 'Новости')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Новости</b></div>
<?php if(!empty($list_news)): ?>
	<?php foreach($list_news as $news): ?>
	<div class="menu">
	<img src="<?php echo URL ?>modules/news/images/news.png" alt="" /> <a href="<?php echo a_url('news/detail', 'news_id='. $news['news_id']) ?>"><?php echo $news['subject'] ?></a> (<?php echo date('d.m.Y', $news['time']) ?>)
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block">
	<b>Новостей нет</b>
	</div>
<?php endif; ?>

<?php if($pagination)
	echo '<div class="block">'. $pagination .'</div>';
?>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>