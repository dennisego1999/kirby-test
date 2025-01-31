<?php

include __DIR__ . '/../kirby/vendor/autoload.php';


$kirby = new Kirby([
    'roots' => [
        'index'    => __DIR__,
        'base'     => $base = dirname(__DIR__),
        'content'  => $base . '/content',
        'site'     => $base . '/site',
    ]
]);

echo $kirby->render();