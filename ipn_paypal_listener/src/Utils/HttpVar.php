<?php

declare(strict_types=1);

namespace Utils;

class HttpVar {

	public function PostDataToKeyPairValue($raw_post_data) {
		
		$raw_post_array = explode('&', $raw_post_data);
		
		$my_post = array();
		
		foreach ($raw_post_array as $key_val) {
			$key_val = explode ('=', $key_val);
			if (count($key_val) == 2)
				$my_post[$key_val[0]] = urldecode($key_val[1]);
		}
		
		// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
		$req = 'cmd=_notify-validate';
		
		if (function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		
		foreach ($my_post as $key => $value) {
			if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}

		return $req;
	}
}
?>