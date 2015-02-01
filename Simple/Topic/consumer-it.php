<?php
include __DIR__ . "/include.php";

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
$queue->declareQueue();

$queue->bind('test-topic', '#.it');
$queue->bind('test-topic', '#.it.#');
$queue->bind('test-topic', 'it.#');

$f = function(AMQPEnvelope $message, AMQPQueue $queue) {
    print_r("[It] Received message " . $message->getBody() . " on routing key: " . $message->getRoutingKey() . "\n");
    $queue->ack($message->getDeliveryTag());
    return true;
};

$queue->consume($f);