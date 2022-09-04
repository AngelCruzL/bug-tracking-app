<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/exception/exception.php';


$db = new mysqli('failure', 'root', '', 'bug');
exit;

$config = \App\Helpers\Config::get('not3xist');
var_dump($config);

// $application = new App\Helpers\App();
// echo $application->getServerTime()->format('Y-m-d H:i:s') . PHP_EOL;
// echo $application->getLogPath() . PHP_EOL;
// echo $application->getEnvironment() . PHP_EOL;
// echo $application->isDebugMode() . PHP_EOL;

// if ($application->isRunningFromConsole()) {
//   echo 'Running from console' . PHP_EOL;
// } else {
//   echo 'Running from web server' . PHP_EOL;
// }
