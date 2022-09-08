<?php

namespace Tests\Units;

use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
  public function testItThrowMissingArgumentExceptionWithWrongCredentialKeys()
  {
    self::expectException(MissingArgumentException::class);
    $credentials = [];
    $pdoHandler = new PDOConnection($credentials);
  }

  public function testItCanConnectToDatabaseWithPdoApi()
  {
    $credentials = [];
    $pdoHandler = (new PDOConnection($credentials))->connect();
    self::assertNotNull($pdoHandler);
  }
}
