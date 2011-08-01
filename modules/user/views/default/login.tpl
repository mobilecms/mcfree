<?php $this->display('header', array('sub_title' => 'Вход')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Вход</b></div>

<?php if($error): ?>
    <div class="error">
    <?php echo $error ?>
    </div>
<?php endif ?>

<form action="<?php echo a_url('user/login') ?>" method="get">
<div class="menu">

Логин:<br />
<input name="username" class="input" type="text" value="<?php echo @$_GET['username'] ?>" /><br />

Пароль:<br />
<input name="password" type="password" value="<?php echo @$_GET['password'] ?>" /><br />

<input name="remember_me" type="checkbox" value="ON" checked="checked" /> запомнить<br />

<input type="submit" class="but" value="Вход" />
</div>
</form>

<div class="block">
<a href="<?php echo a_url('user/registration') ?>">Регистрация</a><br />
<a href="<?php echo a_url('user/forgot') ?>">Напомнить пароль</a><br />
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>