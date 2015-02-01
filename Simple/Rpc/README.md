# RPC

__Assume you have a server from which you want to know what is the disk usage. How can that be acomplished using RabbitMQ?__

In order to achieve the task, we will use the following components:

    * one server which we need to monitor
    * one producer which wants to know the status of the server
    * one fanout exchange to distribute the request for status

This pattern is known as remote procedure call. Basically it is remote function invocation, awaiting always for a response.
We will use in this example some interesting AMQP specifications. 

    * AMQP specification says that when a queue is declared, it is by default bounded to the default unnamed exchange 
    with the queue name as the routing key. we will use this feature to create the reply queue.
    * we will declare the reply queue as AUTODELETED and EXCLUSIVE, meaning that the queue will disappear as soon as we 
    are done with it and it can only be used by our channel.
    
Attached are three files: producer, consumer and cleanup. Start first the consumer and one producer after the consumer has 
been started. In order to clean all leftovers please run cleanup.php.

_Why can't we use consume and we use get in the producer?_
_Why do we have to declare the reply queue before we start asking for messages?_