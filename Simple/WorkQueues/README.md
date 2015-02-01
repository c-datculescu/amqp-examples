# Worker Queues

__You work in a web company that sells things. You do not want to process images to be processed on the live servers, 
therefore you set up some processing servers for the images. How would you model the AMQP infrastructure for this goal?__

This concept is known as work queues. It relies on the fact that multiple listeners can consume from the same queue.
Therefore, to implement such a thing, we need to push messages to one queue and have more than one consumer to process
the messages.

Attached are two files: producer and consumer. Start first two consumers and one producer after the two consumers have 
been started.

See the results as they come through.