#!/usr/bin/python

import pika

from interface import implements

from abstract.interface_mq_connection import InterfaceRabbitMqConnection

class RabbitMQConnection(implements(InterfaceRabbitMqConnection)):

	def create_connection(self,host):
	
		connection = pika.BlockingConnection(pika.ConnectionParameters(host=host))
		channel = connection.channel()
		
		return channel

