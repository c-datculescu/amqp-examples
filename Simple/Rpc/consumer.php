<?php
include __DIR__ . "/include.php";

$queue = new AMQPQueue($channel);
$queue->setName('test-rpc');
$queue->setFlags(AMQP_DURABLE);
$queue->declareQueue();

$queue->bind('test-rpc', '');

$f = function(AMQPEnvelope $message, AMQPQueue $queue) {
    print_r($message->getBody() . "\n");
    $queue->ack($message->getDeliveryTag());

    // reply on the core exchange?
    $channel = $queue->getChannel();

    $exchange = new AMQPExchange($channel);
    $exchange->publish('hdd answer!!!', $message->getReplyTo());
};

$queue->consume($f);