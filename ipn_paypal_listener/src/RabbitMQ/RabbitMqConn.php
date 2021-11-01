<?php

declare(strict_types=1);

namespace RabbitMQ;

require_once('././vendor/autoload.php');

class RabbitMqConn {
	
	public function ConnectionMqSettings(string $host, int $port=5672, string $username="guest", string $password="guest") {
		$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
			$host, 
			$port, 
			$username, 
			$password
		);
		
		return $connection;
	}
}
?>