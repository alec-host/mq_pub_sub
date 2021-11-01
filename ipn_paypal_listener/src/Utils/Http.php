<?php

declare(strict_types=1);

namespace Utils;

class Http {
	
	public function __construct() {}	
	
	/**
	* @param_1: url
	* @param_2: request
	* @return: array
	*/
	public function curl_post(string $url,string $request) {
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

		$res = curl_exec($ch);

		return [$ch,$res];
	}
}
?>