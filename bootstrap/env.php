<?php

use Beebmx\KirbyEnv;

if (file_exists(__DIR__ . '/../.env')) {
    KirbyEnv::load();
} else {
    trigger_error('No .env file found. Please create one based on .env.example', E_USER_WARNING);
}
