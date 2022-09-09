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
    'host',
    'username',
    'password',
    'database'
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
      $credentials['host'],
      $credentials['username'],
      $credentials['password'],
      $credentials['database'],
    ];
  }

  public function getConnection(): mysqli
  {
    return $this->connection;
  }
}
