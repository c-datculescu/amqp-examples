<?php
$connectionArray = array(
    'host' => 'localhost',
    'port' => 5672,
    'vhost' => '/',
    'login' => 'guest',
    'password' => 'guest'
);

$connection = new AMQPConnection($connectionArray);
$connection->connect();

$channel = new AMQPChannel($connection);

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
$queue->declareQueue();

$queue->bind('test-pubsub', '#');

$f = function(AMQPEnvelope $message, AMQPQueue $queue) {
    echo "Received delete request for image: " . $message->getBody() . " on server " . $queue->getName() . "\n";
    $queue->ack($message->getDeliveryTag());
};

$queue->consume($f);