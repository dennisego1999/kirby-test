<?php

require_once dirname(__DIR__) . '/bootstrap.php';

use Kirby\Cms\App as Kirby;

echo Kirby::instance()->render();
