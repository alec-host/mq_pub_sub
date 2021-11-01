<?php

declare(strict_types=1);

namespace RabbitMQ;

interface RabbitMqInterface {

	public function CreateMqChannel($connection);
}
?>