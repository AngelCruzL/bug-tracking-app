<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$app = new App\Helpers\App();
echo $app->getServerTime()->format('Y-m-d H:i:s') . PHP_EOL;
echo $app->getLogPath() . PHP_EOL;
echo $app->getEnvironment() . PHP_EOL;
echo $app->isDebugMode() . PHP_EOL;

if ($app->isRunningFromConsole()) {
  echo 'Running from console' . PHP_EOL;
} else {
  echo 'Running from web server' . PHP_EOL;
}
