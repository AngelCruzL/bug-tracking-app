<?php

namespace App\Exception;

use App\Helpers\App;
use Throwable;

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
}
