<form action="<?php echo a_url('user/admin') ?>" method="get">

ID пользователя:<br />
<input style="margin-left: 15px" size="14" type="text" name="user_id" value="<?php echo @$_GET['user_id'] ?>" /><br />

Логин:<br />
<input style="margin-left: 15px" size="14" name="username" type="text" value="<?php echo @$_GET['username'] ?>" /><br />

Статус пользователей:<br />
<select style="margin-left: 15px" name="status">
<option value="">---</option>
<option value="user"<?php if(@$_GET['status'] == 'user') echo ' selected="selected"'; ?>>пользователи</option>
<option value="moder"<?php if(@$_GET['status'] == 'moder') echo ' selected="selected"'; ?>>модераторы</option>
<option value="admin"<?php if(@$_GET['status'] == 'admin') echo ' selected="selected"'; ?>>администраторы</option>
</select><br />

Сортировать по:<br />
<select style="margin-left: 15px" name="sort">
<option label="возрастанию" value="asc">возрастанию</option>
<option label="убыванию" value="desc"<?php if(@$_GET['sort'] == 'desc') echo ' selected="selected"'; ?>>убыванию</option>
</select><br /><br />

<input style="margin-left: 15px" type="submit" value="Поиск..">

</form>