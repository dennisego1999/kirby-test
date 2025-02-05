<?php

use Beebmx\KirbyEnv;

try {
    KirbyEnv::load('../');
} catch (\Exception $e) {
    error_log('Failed to load environment file: ' . $e->getMessage());
}
