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
    if ($i%3 == 0) {
        $routingKey = "politics.it";
        $newsName = "news from both politics and it";
    } elseif ($i % 3 == 1) {
        $routingKey = "it";
        $newsName = "news from it";
    } else {
        $routingKey = "politics";
        $newsName = "news from politics";
    }
    $exchange->publish($newsName, $routingKey);
    usleep(500000);
}