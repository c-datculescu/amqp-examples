# RoutingMessages

__Assume you have a news aggregator. Assume also that you have one or more clients, but some of these clients are interested
in news about politics while others are interested in news about IT. How would such an infrastructure look in RabbitMQ?__

This concept is known as routing messages. In order to implement the desired action we will use:

    * two consumers, one listening for news from politics, one listening for news from it
    * one producer publishing news about both politics and it
    * we will use direct exchanges to implement such a thing

Extra case: what if a news is related to both politics and it?

As in the PubSub example, we will use the ability to declare anonymous queues as well as the AUTODELETE flag for the queues 
on which the messages will land.

Attached are four files: producer, consumer-politics, consumer-it and cleanup. Start first the two consumers and one producer 
after the two consumers have been started. In order to clean all leftovers please run cleanup.php.

See the results as they come through.

_Additional question: How would this kind of implementation look over a TOPIC exchange? I leave that as an exercise
for practice._