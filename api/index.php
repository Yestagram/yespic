<?php

use BunnyPHP\BunnyPHP;

header('X-Powered-By:BunnyFramework');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

const APP_PATH = __DIR__ . '/../';
const APP_DEBUG = true;
date_default_timezone_set('PRC');
require(APP_PATH . 'vendor/autoload.php');
(new BunnyPHP())->run();