<?php
include __DIR__ . "/include.php";

$exchange->delete();

$queue = new AMQPQueue($channel);
$queue->setName('test-rpc');
$queue->setFlags(AMQP_DURABLE);
$queue->delete();