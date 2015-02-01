# Topic

__Assume a news aggregator. The news aggregator publishes on a exchange news related to multiple domains. Assume two clients.
One client is interested in news from politics and one in news from it. How would such an infrastructure look in RabbitMQ?__

This pattern is known as topic routing. In order to implement this pattern, we will use:
    
    * two consumers, one listening for news from it, one for news from politics
    * one producer which pushes the news
    * one __TOPIC__ exchange on which we push the news
    
As in the PubSub example, we will use the ability to declare anonymous queues as well as the AUTODELETE flag for the queues 
on which the messages will land.

Attached are four files: producer, consumer-it, consumer-politics and cleanup. Start first the two consumers and one 
producer after the two consumers have been started. In order to clean all leftovers please run cleanup.php.

See the results as they come through.

_What happens if a news is both politics and it related?_
_What happens with messages that are neither politics or it?_
_Why are there three bindings for each queue?_