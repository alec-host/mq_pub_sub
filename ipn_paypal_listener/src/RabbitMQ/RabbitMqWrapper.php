<?php

declare(strict_types=1);

namespace RabbitMQ;

require('RabbitMqInterface.php');

require_once('././vendor/autoload.php');

use RabbitMQ\RabbitMqInterface;

final class RabbitMqWrapper implements RabbitMqInterface {
	
	private $rabbit_mq_connection = null;
	
	public function __construct(RabbitMqConn $rabbit_mq_connection) {
		$this->rabbit_mq_connection = $rabbit_mq_connection;
	}
	
	public function CreateMqChannel($connection) {
		return $connection->channel();
	}
	
	public function DefineMqQueueName($channel,$channel_name) {
		$channel->queue_declare(
			$queue = $channel_name,
			$passive = false,
			$durable = false,
			$exclusive = false,
			$auto_delete = false,
			$nowait = false,
			$arguments = null,
			$ticket = null
		);		
	}
	
	public function PackageMqMessage(array $payload) {
		$msg = new \PhpAmqpLib\Message\AMQPMessage(
			json_encode($payload, JSON_UNESCAPED_SLASHES),
			array('delivery_mode' => 2) # make message persistent
		);
		
		return $msg;
	}
	
	public function PublishMqMessage($channel,$channel_name,$message) {
		$channel->basic_publish($message, '', $channel_name);
	}
}
?>