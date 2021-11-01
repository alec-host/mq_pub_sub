#!/usr/bin/python

from time import gmtime, strftime

class RabbitMQWrapper:

	def __init__(self,queue_name,exchange_name,exchange_type):
	
		self.queue_name = queue_name
		self.exchange_name = exchange_name
		self.exchange_type = exchange_type
	
	def consumer(self,channel):

		result = channel.queue_declare(queue=self.queue_name, exclusive=False)
		queue_name = result.method.queue

		channel.queue_bind(exchange=self.exchange_name, queue=queue_name)
		
		print('[*] Waiting for logs. To exit press CTRL+C')
		
		def callback(ch, method, properties, body):
			print("["+strftime("%Y-%m-%d %H:%M:%S", gmtime())+"] %r" % body)
			
		channel.basic_consume(callback, queue=queue_name, no_ack=True)

		channel.start_consuming()
		
	def producer(self):
	
		pass
		
	def define_mq_queue(self,channel):

		channel.exchange_declare(exchange=self.exchange_name, exchange_type=self.exchange_type)