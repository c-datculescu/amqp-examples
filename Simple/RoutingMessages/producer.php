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
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->setFlags(AMQP_DURABLE);
$exchange->declareExchange();

for ($i = 0; $i < 100; $i++) {
    if ($i%2 == 0) {
        $routingKey = "critical";
        $newsName = "critical error";
    } else {
        $routingKey = "warning";
        $newsName = "warning error";
    }
    $exchange->publish($newsName, $routingKey);
    usleep(500000);
}