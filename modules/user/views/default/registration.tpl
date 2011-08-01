<?php $this->display('header.tpl', array('sub_title' => 'Регистрация')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" />Регистрация</div>

<?php IF($error): ?>
<div class="error">
<?php echo $error; ?>
</div>
<?php ENDIF ?>

<form action="<?php echo a_url('user/registration') ?>" method="post">
<div class="menu">
Логин:<br />
<input name="username" type="text" value="<?php echo htmlspecialchars(@$_POST['username']) ?>" /><br />

E-mail:<br />
<input name="email" type="text" value="<?php echo @htmlspecialchars(@$_POST['email']) ?>" /><br />

Пароль:<br />
<input name="password" type="password" value="" /><br />

Подтвердите пароль:<br />
<input name="password2" type="password" value="" /><br />

Введите код с картинки:<br />
<img src="<?php echo URL ?>utils/captcha.php" /><br />
<input name="captcha_code" type="text" value="" /><br />

<input type="submit" name="submit" value="Регистрация" />
</div>
</form>

<div class="block">
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer.tpl') ?>