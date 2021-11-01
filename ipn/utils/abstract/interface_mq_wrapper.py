#!/usr/bin/python

from interface import Interface

class InterfaceRabbitMqWrapper(Interface):

	def consumer(self,channel):
		pass
	
	def producer(self):
		pass

	def define_mq_queue(self,channel):
		pass