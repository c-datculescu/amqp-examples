# RoutingMessages

__Assume you have an error dispatcher. There are many types of error levels, let's assume the that our application has 
two: critical and warning. One client will be interested in the critical errors so it cans end alerts, while the other 
will be interested in notices so it can graph them. How would such an infrastructure look in RabbitMQ?__

This concept is known as routing messages. In order to implement the desired action we will use:

    * two consumers, one listening for logs marked as critical, one listening for logs marked as warnings
    * one producer publishing both critical and warning errors
    * we will use direct exchanges to implement such a thing

As in the PubSub example, we will use the ability to declare anonymous queues as well as the AUTODELETE flag for the queues 
on which the messages will land.

Attached are four files: producer, consumer-critical, consumer-warning and cleanup. Start first the two consumers and one 
producer after the two consumers have been started. In order to clean all leftovers please run cleanup.php.

See the results as they come through.