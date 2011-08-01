<?php $this->display('header', array('title' => 'Гостевая книга | Написать')) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" />Гостевая книга | Написать</div>

<?php if($error): ?>
<div class="error">
<?php echo $error ?>
</div>
<?php endif ?>

<form action="<?php echo a_url('guestbook/say') ?>" method="post">
<div class="menu">
<?php if(USER_ID == -1): ?>
Ваше имя:<br />
<input name="username" type="text" value="<?php echo $_COOKIE['username'] ?>" /><br />
<?php else: ?>
<input name="username" type="hidden" value="<?php echo $user['username'] ?>" />
<?php endif; ?>
Сообщение:<br />
<textarea name="message" rows="5" cols="20"><?php echo htmlspecialchars($_POST['message']) ?></textarea><br />
<?php if(USER_ID == -1): ?>
Введите код с картинки:<br />
<img src="<?php echo URL ?>utils/captcha.php" /><br />
<input name="captcha_code" type="text" value="" /><br />
<?php endif; ?>
<input type="submit" name="submit" value="Отправить" />
</div>
</form>

<div class="block">
<a href="<?php echo a_url('smiles', 'return_name='. urlencode('Написать') .'&amp;return_url='. urlencode(a_url('guestbook/say'))) ?>">Смайлы</a><br />
<a href="<?php echo a_url('main/bbcode', 'return_name='. urlencode('Написать') .'&amp;return_url='. urlencode(a_url('guestbook/say'))) ?>">Теги (bbcode)</a><br />
<a href="<?php echo a_url('guestbook') ?>">В гостевую</a><br />
<a href="<?php echo URL ?>">На главную</a><br />
</div>

<?php $this->display('footer') ?>