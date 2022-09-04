<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/exception/exception.php';

$logger = new App\Logger\Logger();
$logger->log(\App\Logger\LogLevel::EMERGENCY, 'This is an emergency message', ['exception' => 'exception occurred']);
$logger->info('User account created successfully', ['id' => 5]);
