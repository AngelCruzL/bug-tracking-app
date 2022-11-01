<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Database\AbstractConnection;
use App\Exception\DatabaseConnectionException;
use mysqli;
use mysqli_driver;
use Throwable;

class MySQLiConnection extends AbstractConnection implements DatabaseConnectionInterface
{
  const REQUIRED_CONNECTION_KEYS = [
    'DB_HOST',
    'DB_USER',
    'DB_PASS',
    'DB_NAME',
    'DB_PORT'
  ];

  public function connect(): MySQLiConnection
  {
    $driver = new mysqli_driver;
    $driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;
    $credentials = $this->parseCredentials($this->credentials);

    try {
      $this->connection = new mysqli(...$credentials);
    } catch (Throwable $exception) {
      throw new DatabaseConnectionException(
        $exception->getMessage(),
        $this->credentials,
        500
      );
    }

    return $this;
  }

  protected function parseCredentials(array $credentials): array
  {
    return [
      $credentials['DB_HOST'],
      $credentials['DB_USER'],
      $credentials['DB_PASS'],
      $credentials['DB_NAME'],
      $credentials['DB_PORT']
    ];
  }

  public function getConnection(): mysqli
  {
    return $this->connection;
  }
}
