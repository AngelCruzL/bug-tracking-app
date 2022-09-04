<?php

declare(strict_types=1);

namespace App\Exception;

use App\Helpers\App;
use Throwable, ErrorException;

class ExceptionHandler extends BaseException
{
  public function handle(Throwable $exception): void
  {
    $application = new App();

    if ($application->isDebugMode()) {
      var_dump($exception);
    } else {
      echo 'Something went wrong, please try again later.';
    }

    exit;
  }

  public function convertWarningsAndNoticesToException($severity, $message, $file, $line): void
  {
    throw new ErrorException($message, $severity, $severity, $file, $line);
  }
}
