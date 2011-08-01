<?php echo $this->display('header', array('sub_title' => 'Поиск файлов')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" />Поиск файлов</div>

<?php if($error): ?>
<div class="error">
<?php echo $error ?>
</div>
<?php endif ?>

<form action="<?php echo a_url('downloads/search_form') ?>" method="get">
<div class="menu">
Что ищем:<br />
<input name="search_word" type="text" value="" /><br />
Где ищем:<br />
<select size="1" name="directory_id">
	<?php if($directory_id > 0): ?>
	<option value="<?php echo $directory_id ?>"><?php echo $directory['name'] ?></option>
	<?php endif; ?>
  	<option value="0">Во всех папках</option>
</select><br />

<input name="send" type="hidden" value="1" />
<input type="submit" value="Поиск" />
</div>
</form>

<div class="block">
<?php if($directory_id > 0): ?>
<a href="<?php echo URL ?>downloads/<?php echo $directory_id ?>"><?php echo $directory['name'] ?></a><br />
<?php endif; ?>
<a href="<?php echo a_url('downloads') ?>">Загрузки</a><br />
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>