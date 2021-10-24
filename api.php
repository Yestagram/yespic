<?php

use BunnyPHP\BunnyPHP;

header('X-Powered-By:BunnyFramework');
const APP_PATH = __DIR__ . '/';
const APP_DEBUG = true;
date_default_timezone_set('PRC');
require 'vendor/autoload.php';
(new BunnyPHP(BunnyPHP::MODE_API))->run();