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

$exchange = new AMQPExchange($channel);
$exchange->setName('test-routing');
$exchange->setType(AMQP_EX_TYPE_TOPIC);
$exchange->setFlags(AMQP_DURABLE);
$exchange->declareExchange();

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
$queue->declareQueue();

$queue->bind('test-routing', "#.it.#");

$f = function(AMQPEnvelope $message, AMQPQueue $queue) {
    print_r("Received on the it listener message: " . $message->getBody() . " -- " . $message->getRoutingKey() . "\n");
    $queue->ack($message->getDeliveryTag());
    return true;
};

$queue->consume($f);
