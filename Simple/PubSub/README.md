# PubSub

__Assume you have a farm of 2 servers for storing static content like images. Assume you want a specific image removed 
from all 30 servers at the same time. How would you model such a infrastructure in RabbitMQ?__

This concept is known as PubSub. In order to achieve the desired action, we will use the following:

    * two consumers representing the two servers
    * one producer launching the request to process the image deletion
    * from RabbitMQ point of view we will use a Fanout exchange to achieve the desired goal
    
Fanout exchanges have the property that they ignore the routing key, and distribute the message to all the bounded 
queues for the exchange. See consumer.php for more details.

We will also rely in this simple example on the ability of declaring anonymous queues: queues with no specified names
that receive a randomly generated name when declared.

One other important property we will use is the AUTODELETE flag. The autodelete flag allows us to remove the generated queue
immediately as we stop listening on it, avoiding messages piling up in the queue and killing it. In some cases it is 
desired to be used, in other cases not (if for example the consumer is temporarily unavailable, but we want to keep the 
messages, we will not set autodelete on the queue).

Attached are three files: producer, consumer and cleanup. Start first two consumers and one producer after the two consumers have 
been started. In order to clean all leftovers please run cleanup.php.

See the results as they come through.