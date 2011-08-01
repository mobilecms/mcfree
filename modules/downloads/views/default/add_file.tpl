<?php $this->display('header.tpl', array('sub_title' => 'Загрузки')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" />Добавить файл</div>

<?php if($error): ?>
<div class="error">
<?php echo $error ?>
</div>
<?php endif ?>

<form action="<?php echo a_url('downloads/add_file', 'directory_id='. $_GET['directory_id']) ?>" method="post" enctype="multipart/form-data">
<div class="menu">
Название:<br />
<input name="name" type="text" value="<?php echo htmlspecialchars($_POST['name']) ?>" /><br />
Загрузить файл:<br />
<input name="file_upload" type="file" value="" /><br />
Или импортировать с другого сайта:<br />
<input name="file_import" type="text" value="http://" /><br />
Описание файла:<br />
<textarea name="about" rows="5"><?php echo htmlspecialchars($_POST['about']) ?></textarea><br />
Загрузить скриншот:<br />
<input name="screen1" type="file" /><br />
Или импортировать с другого сайта:<br />
<input name="screen1" type="text" value="http://" /><br />
<input type="submit" name="submit" value="Загрузить" />
</div>
</form>

<div class="block">
<a href="<?php echo URL ?>downloads">Загрузки</a><br />
<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>