<?php echo $this->display('header', array('sub_title' => 'Напомнить пароль')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Напомнить пароль</b></div>

<?php if($error): ?>
<div class="error">
<?php echo $error ?>
</div>
<?php endif ?>

<form action="<?php echo a_url('user/forgot') ?>" method="post">
<div class="menu">
Имя пользователя:<br />
<input name="username" type="text" value="<?php echo $_POST['username'] ?>" /><br />

или<br />

E-mail:<br />
<input name="email" type="text" value="<?php echo $_POST['email'] ?>" /><br />

<input type="submit" name="submit" value="Отправить" />
</div>
</form>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>