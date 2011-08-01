<?php
ini_set('session.save_path', '../tmp/');
session_name('sid');
session_start();

switch (@$_GET['a']) {
	case 'check':
		$_SESSION['captcha_code'] = strval(rand(1000, 9999));
		echo '<form action="captcha.php" method="get">'.
			'<input type="hidden" name="a" value="submit">'.
			'<label for="code">Код подтверждения:</label>'.
			'<input type="text" id="code" name="code" size="4" maxlength="4">'.
			'<img align="absmiddle" src="captcha.php?a=image">'.
			'<input type="submit" value="Go">'.
			'</form>';
	break;
	case 'submit':
		//проверка кода
		if (empty($_GET['code']) or empty($_SESSION['code'])) {
			echo 'Вы не указали код подтверждения';
		} elseif ($_GET['code'] != $_SESSION['code']) {
			echo 'Код подтверждения не совпадает';
		} else {
			echo 'Всё Ok!';
		}
	break;
	default:
		$im = imagecreate (80, 20) or die ("Cannot initialize new GD image stream!");
		$bg = imagecolorallocate ($im, 232, 238, 247);
		$char = $_SESSION['captcha_code'];

		//создаём шум на фоне
		for ($i=0; $i<=128; $i++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255)); //задаём цвет
			imagesetpixel($im, rand(2,80), rand(2,20), $color); //рисуем пиксель
		}

		//выводим символы кода
		for ($i = 0; $i < strlen($char); $i++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,128), rand(0,255)); //задаём цвет
			$x = 5 + $i * 20;
			$y = rand(1, 6);
			imagechar ($im, 5, $x, $y, $char[$i], $color);
		}

		/*/упрощённый вариант
		$color = imagecolorallocate($img, 0, 0, 0);
		imagestring($im, 3, 5, 3, $char, $color);*/

		//антикеширование
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		//создание рисунка в зависимости от доступного формата
		if (function_exists("imagepng")) {
			header("Content-type: image/png");
			imagepng($im);
		}
		elseif (function_exists("imagegif")) {
			header("Content-type: image/gif");
			imagegif($im);
		}
		elseif (function_exists("imagejpeg")) {
			header("Content-type: image/jpeg");
			imagejpeg($im);
		}
		else {
			die("No image support in this PHP server!");
		}
		imagedestroy ($im);
		break;
}
?>