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
$exchange->setName('test-worker-queue');
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->setFlags(AMQP_DURABLE);
$exchange->declareExchange();

$queue = new AMQPQueue($channel);
$queue->setName('actual-worker-queue');
$queue->setFlags(AMQP_DURABLE);
$queue->declareQueue();

$queue->bind('test-worker-queue', 'process-image');

$messageCounter = 0;

$f = function (AMQPEnvelope $message, AMQPQueue $queue) {
    global $messageCounter;
    print_r($message->getBody() . $messageCounter . "\n");
    $queue->ack($message->getDeliveryTag());
    $messageCounter++;
};

$queue->consume($f);