<?php

namespace Tests\Units;

use App\Helpers\App;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
  public function testItCanGetInstanceOfApplication()
  {
    self::assertInstanceOf(App::class, new App());
  }
}
