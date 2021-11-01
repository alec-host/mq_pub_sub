#!/usr/bin/python

import os
import pika
import time
import threading

#from dotenv import load_dotenv


from utils.mq_wrapper import RabbitMQWrapper
from utils.mq_connection import RabbitMQConnection
	
def worker_manager():
	
	workers = []
	'''
	initiate rabbit mq connection.
	'''
	rabbit_mq = RabbitMQConnection()
	'''
	initiate rabbit mq wrapper.
	'''
	rabbit_mq_wrapper = RabbitMQWrapper("ipn_paypal_queue","ipn_exchange","fanout")
	'''
	connect & return channel.
	'''
	channel = rabbit_mq.create_connection("localhost")
	'''
	define queue.
	'''	
	rabbit_mq_wrapper.define_mq_queue(channel)
	
	t1 = threading.Thread(target=rabbit_mq_wrapper.consumer,args=(channel,))
	t1.daemon = True
	workers.append(t1)
	t1.start()
	
	time.sleep(50)
	
	for t in workers:
		t.join()

if __name__ == '__main__':
	try:
		worker_manager()
	except(KeyboardInterrupt,SystemExit):
		print('Mananger: done sleeping; time to stop the threads')
		exit(0)