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

// produce the messages
for ($i = 0; $i < 100; $i++) {
    $exchange->publish('process-image', 'process-image', null);
    echo "Published messsage " . $i . "\n";
    usleep(500);
}