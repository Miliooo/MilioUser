<?php

if (file_exists($file = __DIR__.'/vendor/autoload.php')) {
$loader = require_once $file;
} else {
throw new RuntimeException('Install dependencies to the examples.');
}
