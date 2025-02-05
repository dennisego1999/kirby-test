<?php

use Kirby\Cms\App as Kirby;

new Kirby([
    'roots' => [
        'index' => $public = dirname(__DIR__).'/public',
        'assets' => $public.'/assets',
        'content' => dirname(__DIR__).'/content',
        'site' => $site = dirname(__DIR__).'/site',
        'storage' => $storage = dirname(__DIR__).'/storage',
        'accounts' => $storage.'/accounts',
        'cache' => $storage.'/cache',
        'sessions' => $storage.'/sessions',
        'logs' => $storage.'/logs',
    ],
]);
