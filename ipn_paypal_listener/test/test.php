<?php

declare(strict_types=1);

require('src/Utils/Http.php');
require('src/Utils/HttpVar.php');
require('src/RabbitMQ/RabbitMqConn.php');
require('src/RabbitMQ/RabbitMqWrapper.php');

use Utils\Http;
use Utils\HttpVar;
use RabbitMQ\RabbitMqConn;
use RabbitMQ\RabbitMqWrapper;

$dot_env = Dotenv\Dotenv::createImmutable(__DIR__, 'env\.env');
$dot_env->load();

$http_var = new HttpVar();
$key_pair_data = $http_var->PostDataToKeyPairValue($raw_post_data);

$http = new Http();
$output = ($http->curl_post($_ENV['RABBITMQ_HOST'],$key_pair_data));

if(!$output[1]) {
	curl_close($output[0]);
	exit(0);
}

if(strcmp($output[1], "VERIFIED") == 0) {
	
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
	
	foreach($_POST as $key => $value) {
		echo $key . " = " . $value . "<br>";
	}

	$rabbit_mq_conn = new RabbitMqConn();
	$rabbit_mq_wrapper = new RabbitMqWrapper($rabbit_mq_conn);
	//-.init connection. 
	$mq_connection = $rabbit_mq_conn->ConnectionMqSettings($_ENV['RABBITMQ_HOST']);
	//-.create channel.
	$channel = $rabbit_mq_wrapper->CreateMqChannel($mq_connection);
	
} else if (strcmp ($output[1], "INVALID") == 0) {
	// IPN invalid, log for manual investigation
	echo "The response from IPN was: <b>" . $output[1] ."</b>";
}

curl_close($output[1]);
//print_r($channel);
?>