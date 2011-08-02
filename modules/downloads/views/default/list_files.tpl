<?php $this->display('header', array('sub_title' => $title)) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><?php echo $title ?></div>

<div class="block">
<?php if($directory['user_files'] == 'yes'): ?>
<a href="<?php echo URL .'downloads/'. $directory['directory_id'] .'/add' ?>">Добавить файл</a><br />
<?php endif; ?>
<?php if($action != 'new_files'): ?>
<a href="<?php echo a_url('downloads/list_files', 'action=new_files&amp;directory_id='. $directory['directory_id']) ?>">Новые файлы</a><br />
<?php endif; ?>
<a href="<?php echo a_url('downloads/search_form', 'directory_id='. $directory['directory_id']) ?>"><?php echo ($action == 'search' ? 'Новый поиск' : 'Поиск файлов') ?></a>
</div>

<?php if(!empty($files)): ?>
    <?php foreach($files as $file): ?>
	<div class="menu">
		<?php if($file['type'] == 'directory'): ?>
			<img src="<?php echo URL ?>modules/downloads/views/default/img/dir.png" alt="" />
		<?php elseif($file['previews'] == 'yes' && $_SESSION['downloads_preview'] > 0): ?>
			<img src="<?php echo URL . $file['path_to_file'] .'/preview_'. $_SESSION['downloads_preview'] .'.jpg' ?>" alt="" />
		<?php elseif(file_exists(ROOT .'modules/downloads/views/default/img/'. $file['file_ext'] .'.png')): ?>
			<img src="<?php echo URL ?>modules/downloads/views/default/img/<?php echo $file['file_ext'] ?>.png"  alt="" />
		<?php else: ?>
			<img src="<?php echo URL ?>modules/downloads/views/default/img/file.png" alt="" />
		<?php endif; ?>

		<?php if($file['type'] == 'directory'): ?>
			<a href="<?php echo URL ?>downloads/<?php echo $file['file_id'] ?>"><?php echo $file['name'] ?></a> <?php if($file['count_files'] > 0) echo '<span class="small_text">['. $file['count_files'] .']</span>' . ($file['new_day'] > 0 ? ' <span class="new_files">+'. $file['new_day'] .'</span>' : ''); ?><br />
		<?php else: ?>
			<?php if($file['file_ext'] == 'jpg' || $file['file_ext'] == 'jpeg' || $file['file_ext'] == 'png' || $file['file_ext'] == 'gif'): ?>
				<a href="<?php echo URL ?>download_file/<?php echo $file['file_id'] ?>"><?php echo $file['name'] ?></a> (<?php echo main::byte_format($file['filesize']) ?>) <?php if($file['time'] > time() - 86400): ?><span class="new_files">new!</span><?php endif; ?>
			<?php else: ?>
				<a href="<?php echo URL .'downloads/view/'. $file['file_id'] ?>"><?php echo $file['name'] ?></a> (<?php echo main::byte_format($file['filesize']) ?>) <?php if($file['time'] > time() - 86400): ?><span class="new_files">new!</span><?php endif; ?><br />
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="block">
	<p>Файлов не найдено!</p>
	</div>
<?php endif; ?>

<?php if($pagination)
	echo '<div class="block">'. $pagination .'</div>';
?>

<?php if($is_files_directory): ?>
<div class="block">
<span class="small_text">
Сортировать по:
<?php if($_SESSION['order_by'] == 'time' || !isset($_SESSION['order_by'])): ?><u>дате</u><?php else: ?><a href="<?php echo URL ?>downloads/<?php echo $directory['directory_id'] ?>?order_by=time">дате</a><?php endif; ?> /
<?php if($_SESSION['order_by'] == 'name'): ?><u>имени</u><?php else: ?><a href="<?php echo URL ?>downloads/<?php echo $directory['directory_id'] ?>?order_by=name">имени</a><?php endif; ?> /
<?php if($_SESSION['order_by'] == 'downloads'): ?><u>скачиваниям</u><?php else: ?><a href="<?php echo URL ?>downloads/<?php echo $directory['directory_id'] ?>?order_by=downloads">скачиваниям</a><?php endif; ?>
</span>
</div>
<?php endif; ?>

<div class="block">
<?php if(!empty($navigation)) echo $navigation .'<br />'; ?>
<?php if($directory['directory_id'] > 0) echo '<a href="'. a_url('downloads') .'">Загрузки</a><br />'; ?>
<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>