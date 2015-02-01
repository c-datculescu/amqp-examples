<?php
include __DIR__ . "/include.php";

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_AUTODELETE | AMQP_EXCLUSIVE);
$queue->declareQueue();

$f = function(AMQPEnvelope $message, AMQPQueue $queue) {
    print_r($message->getBody() . "\n");
    $queue->ack($message->getDeliveryTag());
    return true;
};

// do not bind the queue
for ($i = 0; $i < 30; $i++) {
    $exchange->publish('show me za space!', null, AMQP_NOPARAM, array('reply_to' => $queue->getName()));
    $res = false;
    while ($res == false) {
        $envelope = $queue->get(AMQP_NOPARAM);
        if ($envelope instanceof AMQPEnvelope) {
            $res = true;
            $f($envelope, $queue);
        }
    }
}