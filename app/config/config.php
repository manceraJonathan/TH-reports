<?php

namespace App\Config;

$env_file = @file('../../.env') or die('El archivo .env no ha sido encontrado.');

foreach ($env_file as $line) {
    list($key, $value) = explode('=', $line, 2);

    $value = trim($value);

    putenv("$key=$value");
}

define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_CHARSET', getenv('DB_CHARSET'));