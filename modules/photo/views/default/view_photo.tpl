<?php $this->display('header', array('title' => $photo['name'])) ?>

<div class="title"><img src="<?php echo URL ?>views/<?php echo THEME ?>/img/titl.gif" class="ico" alt="" /><b><a href="<?php echo a_url('photo/list_photos', 'album_id='. $album['album_id'] .'&amp;user_id='. $user_id); ?>"><?php echo $album[name] ?></a></b> | <b><?php echo $photo['name'] ?></b></div>

<div class="menu">
<?php echo $photo['image'] ?>
<?php echo $widht ?>
<?php if (!empty($photo['about'])): echo $photo['about'] .'<br />'; endif; ?>
Альбом: <a href="<?php echo a_url('photo/list_photos', 'user_id='. $photo['user_id'] .'&amp;album_id='. $album['album_id']) ?>"><?php echo $album['name'] ?></a><br />
Добавил: <a href="<?php echo a_url('user/profile/view', 'user_id='. $photo['user_id']) ?>"><?php echo $photo['username'] ?></a><br />
Дата: <?php echo date('d.m.Y в H:i', $photo['time']) ?><br />
<img src="<?php echo URL ?>modules/comments/images/comment.png" alt="" /> <a href="<?php echo a_url('comments', 'module=photo&amp;item_id='. $photo['photo_id'] .'&amp;return='. urlencode(URL .'photo/view/'. $photo['user_id'] .'/'. $photo['album_id'] .'/'. $photo['photo_id'])) ?>">Комментарии</a> <span class="small_text">[<?php echo $photo['comments'] ?>]</span><br /><br />

Адрес фотографии:<br />
<input type="text" name="text" value="<?php echo URL .'photo/view/'. $photo['user_id'] .'/'. $photo['album_id'] .'/'. $photo['photo_id'] ?>" />
</div>

<div class="block">
<a href="<?php echo a_url('photo/list_all_albums') ?>">Фотоальбомы</a><br />
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>