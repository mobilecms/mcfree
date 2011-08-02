<?php $this->display('header.tpl', array('sub_title' => $title)) ?>

<?php if ($error) echo '<div class="error">'. $error .'</div>' ?>

<?php $this->display('title.tpl', array('title' => $title)) ?>

<form method="post" action="<?php echo URL .'downloads/'. $directory['directory_id'] .'/add' ?>" enctype="multipart/form-data">
	<div class="menu">
	    Название: <br />
	    <input type="text" name="name" value="<?php echo $file['name'] ?>" /><br />
	    
	    <?php echo ($action == 'edit' ? 'Выгрузить другой файл' : 'Выгрузить файл') ?>:<br />
		<input type="file" name="file_upload" /><br />
		
		<?php echo ($action == 'edit' ? 'Импортировать другой файл' : 'Импортировать файл') ?>:<br />
		<input type="text" name="file_import" value="http://" /><br />
		
		<?php echo ($action == 'edit' && $file['screen1'] != '' ? 'Выгрузить другой скриншот' : 'Выгрузить скриншот') ?>:<br />
		<input type="file" name="screen1" /><br />
		
		<?php echo ($action == 'edit' && $file['screen1'] != '' ? 'Импортировать другой скриншот' : 'Импортировать скриншот') ?>:<br />
		<input type="text" name="screen1" value="http://" /><br />
		
		Описание:<br />
	    <textarea name="about" rows="5" cols="20"><?php echo $file['about'] ?></textarea><br />
	    
	    <input type="submit" name="submit" value="Добавить" />
	</div>
</form>

<div class="block">
	<?php if ( ! empty($navigation)) echo $navigation .'<br />' ?>
	<a href="<?php echo URL ?>downloads">Загруз-центр</a><br />
	<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>