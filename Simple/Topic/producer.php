<?php
include __DIR__ . "/include.php";

$tags = array('politics', 'it', 'culture', 'science');

for ($i = 0; $i < 100; $i++) {
    shuffle($tags);
    // how many tags we should have:
    $howManyTags = mt_rand(1, 2);
    $localTags = array_rand($tags, $howManyTags);
    if (!is_array($localTags)) {
        $tempTags = array();
        $tempTags[] = $localTags;
        $localTags = $tempTags;
    }
    $messageTags = array();
    foreach ($localTags as $tag) {
        $messageTags[] = $tags[$tag];
    }

    $exchange->publish("news incoming", implode(".", $messageTags));
    usleep(500000);
}