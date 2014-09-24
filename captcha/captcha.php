<?php

session_start();
	unset($_SESSION['captcha_spam']);

	function MakeAlphabet(){

		for ($x = 65; $x <= 90; $x++) {
			if($x != 73 && $x != 76 && $x != 79)
				$alphabet[] = chr($x);
		}

		for ($x = 97; $x <= 122; $x++) {
			if($x != 105 && $x != 108 && $x != 111)
				$alphabet[] = chr($x);
		}

		for ($x = 48; $x <= 57; $x++) {
			if($x != 48 && $x != 49)
				$alphabet[] = chr($x);
		}

		return $alphabet;
	}

	$alphabet = MakeAlphabet();

	shuffle($alphabet); 

	for ($i=0; $i<4; $i++) {
		$text .= $alphabet[$i];
	}
	
	function encrypt($string, $key) {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		return base64_encode($result);
	}

	$_SESSION['captcha_spam'] = encrypt($text, "8h384ls94"); 
	$_SESSION['captcha_spam'] = str_replace("=", "", $_SESSION['captcha_spam']);

	header('Content-type: image/png');
	$img = ImageCreateFromPNG('captcha.PNG'); 
	$color = ImageColorAllocate($img, 0, 0, 0); 
	$ttf = "/home2/svarad/public_html/tagmodo/captcha/Imperator.ttf";
	$ttfsize = 22; 
	$angle = rand(0,1);
	$t_x = rand(50,5);
	$t_y = 30;
	imagettftext($img, $ttfsize, $angle, $t_x, $t_y, $color, $ttf, $text);
	imagepng($img);
	imagedestroy($img);
?>