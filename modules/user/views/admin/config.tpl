<?php $this->display('header', array('title' => 'Настройки модуля пользователей')) ?>

<form action="<?php echo url('user/admin/config') ?>" method="post">
	<div class="box">
		<h3>Настройки модуля пользователей</h3>

		<div class="inside">
		    <p>
		    	<label>Пользователей на страницу (на сайте)</label>
		      	<input name="user_per_page_site" type="text" value="<?php echo $_config['user_per_page_site'] ?>">
	        </p>
	        
	        <p>
		    	<label>Пользователей на страницу (в панели управления)</label>
		      	<input name="user_per_page_panel" type="text" value="<?php echo $_config['user_per_page_panel'] ?>">
	        </p>
		
			<p>
		    	<label>Показывать проверочный код при регистрации?</label>
		    	<select name="registration_captcha">
					<option value="1"<?php if ($_config['registration_captcha'] == '1') echo ' selected="selected"' ?>>Да</option>
					<option value="0"<?php if ($_config['registration_captcha'] == '0') echo ' selected="selected"' ?>>Нет</option>
				</select>
			</p>
			
			<p>
		    	<label>Показывать проверочный при неудачном входе?</label>
		    	<select name="login_captcha">
					<option value="1"<?php if ($_config['login_captcha'] == '1') echo ' selected="selected"' ?>>Да</option>
					<option value="0"<?php if ($_config['login_captcha'] == '0') echo ' selected="selected"' ?>>Нет</option>
				</select>
			</p>
			
			<p>
		    	<label>Приостановить регистрацию</label>
		    	<select name="registration_stop">
					<option value="1"<?php if ($_config['registration_stop'] == '1') echo ' selected="selected"' ?>>Да</option>
					<option value="0"<?php if ($_config['registration_stop'] == '0') echo ' selected="selected"' ?>>Нет</option>
				</select>
			</p>

			<p>
			    <label>Сообщение при приостановленой регистрации</label>
				<textarea name="registration_stop_message" wrap="off"><?php echo $_config['registration_stop_message'] ?></textarea>
			</p>
			
			<p>
		    	<label>Подтверждение E-mail при регистрации</label>
		    	<select name="email_confirmation">
					<option value="1"<?php if ($_config['email_confirmation'] == '1') echo ' selected="selected"' ?>>Вкл</option>
					<option value="0"<?php if ($_config['email_confirmation'] == '0') echo ' selected="selected"' ?>>Выкл</option>
				</select>
			</p>
			
			<p>
		    	<label>Модерация зарегистрированных пользователей</label>
		    	<select name="user_moderate">
					<option value="1"<?php if ($_config['user_moderate'] == '1') echo ' selected="selected"' ?>>Вкл</option>
					<option value="0"<?php if ($_config['user_moderate'] == '0') echo ' selected="selected"' ?>>Выкл</option>
				</select>
			</p>
		</div>
	</div>

<p><input type="submit" id="submit" name="submit" value="Сохранить" /></p>

</form>

<?php $this->display('footer.tpl') ?>