<?php $this->display('header.tpl', array('sub_title' => 'Комментарии')) ?>

<?php if($error): ?>
<div class="error">
<?php echo $error ?>
</div>
<?php endif ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b>Комментарии</b></div>

<div class="block">
<a href="<?php echo a_url('comments', 'module='. $_GET['module'] .'&amp;item_id='. $_GET['item_id'] .'&amp;return='. urlencode($_GET['return']) .'&amp;start='. $start) ?>">Обновить</a>
</div>

<?php if($comments): ?>
<?php foreach($comments AS $comment): ?>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td><?php if($comment['avatar_exists']) echo '<img src="'. URL .'files/avatars/'. $comment['user_id'] .'_32.jpg" alt="" />'; else echo '<img src="'. URL .'files/avatars/empty_32.png" alt="" />'; ?>&#160;</td>
<td>
<b><a href="<?php echo a_url('user/profile/view', 'user_id='. $comment['user_id']) ?>"><?php echo $comment['username'] ?></a></b> [<?php echo a_is_online($comment['last_visit']) ?>] [<a href="<?php echo a_url('comments', 'module='. $_GET['module'] .'&amp;item_id='. $_GET['item_id'] .'&amp;return='. urlencode($_GET['return']) .'&amp;reply='. $comment['username']) .'&amp;start='. $start ?>">отв</a>] <?php if(a_check_rights($comment['user_id'], $comment['user_status'])): ?>[<a href="<?php echo a_url('comments/comment_edit', 'comment_id='. $comment['comment_id'] .'&amp;return_name='. urlencode('Вернуться') .'&amp;return_url='. urlencode(a_url('comments/list_comments', 'module='. $_GET['module'] .'&item_id='. $_GET['item_id'] .'&return='. $_GET['return'] .'&start='. $start))) ?>">изм</a>] [<a href="<?php echo a_url('comments/comment_delete', 'comment_id='. $comment['comment_id'] . '&amp;module='. $_GET['module'] .'&amp;item_id='. $_GET['item_id'] .'&amp;return='. urlencode($_GET['return']) .'&amp;start='. $start) ?>">x</a>]<?php endif; ?><br />
<span style="color: grey; font-size: 11px;">[<?php echo date('d.m.Y в H:i', $comment['time']) ?>]</span>
</td>
</tr>
</table>

<?php echo $comment['text'] ?>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="menu">
Комментариев нет.
</div>
<?php endif; ?>

<?php if ($pagination): ?>
<div class="block">
<?php echo $pagination ?>
</div>
<?php endif ?>

<div class="block">
Всего комментариев: <?php echo $total ?>
</div>

<?php if ($_config['comments_posting'] != 'users' || USER_ID != -1): ?>
<form action="<?php echo a_url('comments/say', 'module='. $_GET['module'] .'&amp;item_id='. $_GET['item_id'] .'&amp;return='. urlencode($_GET['return']) .'&amp;start='. $start) ?>" method="post">
<div class="menu">
<?php if (USER_ID == -1): ?>
Ваше имя:<br />
<input name="username" type="text" value="<?php echo htmlspecialchars($_COOKIE['username']) ?>" /><br />
<?php else: ?>
<input name="username" type="hidden" value="<?php echo $user['username'] ?>" />
<?php endif; ?>
Сообщение: (<a href="<?php echo a_url('smiles', 'return_name='. urlencode('Вернуться') .'&amp;return_url='. urlencode(a_url('comments/list_comments', 'module='. $_GET['module'] .'&item_id='. $_GET['item_id'] .'&return='. $_GET['return']))) ?>">смайлы</a> / <a href="<?php echo a_url('main/bbcode', 'return_name='. urlencode('Вернуться') .'&amp;return_url='. urlencode(a_url('comments', 'module='. $_GET['module'] .'&item_id='. $_GET['item_id'] .'&return='. urlencode($_GET['return'])))) ?>">теги</a>)<br />
<textarea name="message" rows="5" cols="20"><?php if (isset($_GET['reply'])) echo '[b]'. htmlspecialchars($_GET['reply']) .'[/b], '; else echo htmlspecialchars($_POST['message']) ?></textarea><br />
<?php if (USER_ID == -1): ?>
Введите код с картинки:<br />
<img src="<?php echo URL ?>utils/captcha.php" /><br />
<input name="captcha_code" type="text" /><br />
<?php endif; ?>
<input type="submit" name="submit" value="Отправить" />
</div>
</form>
<?php endif; ?>

<div class="block">
<a href="<?php echo urldecode($_GET['return']) ?>">Вернуться</a><br />
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>