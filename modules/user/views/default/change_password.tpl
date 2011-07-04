<?php $this->display('header', array('title' => 'Сменить пароль')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Сменить пароль</b></div>

<?php if($error): ?>
<div class="error">
<?php echo $error ?>
</div>
<?php endif; ?>

<form action="<?php echo a_url('user/change_password') ?>" method="post">
<div class="menu">
Старый пароль (или pin code)*:<br />
<input name="password" type="password" /><br /><br />

Новый пароль:<br />
<input name="new_password" type="password" /><br />
Повторите новый пароль:<br />
<input name="new_password2" type="password" /><br />

<input type="submit" name="submit" value="Применить" />
</div>
</form>

<div class="block">
<a href="<?php echo a_url(MAIN_MENU) ?>">В кабинет</a>
</div>

<?php $this->display('footer') ?>