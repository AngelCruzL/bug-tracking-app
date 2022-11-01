<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Exception\DatabaseConnectionException;
use PDO;
use PDOException;

class PDOConnection extends AbstractConnection implements DatabaseConnectionInterface
{
  const REQUIRED_CONNECTION_KEYS = [
    'DB_DRIVER',
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASS',
    'default_fetch',
  ];

  public function connect(): PDOConnection
  {
    $credentials = $this->parseCredentials($this->credentials);
    try {
      $this->connection = new PDO(...$credentials);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        $this->credentials['default_fetch']
      );
    } catch (PDOException $exception) {
      throw new DatabaseConnectionException($exception->getMessage(), $this->credentials, 500);
    }

    return $this;
  }

  public function getConnection(): PDO
  {
    return $this->connection;
  }

  protected function parseCredentials(array $credentials): array
  {
    $dsn = sprintf(
      '%s:host=%s;dbname=%s;port=%s',
      $credentials['DB_DRIVER'],
      $credentials['DB_HOST'],
      $credentials['DB_NAME'],
      $credentials['DB_PORT']
    );

    return [
      $dsn,
      $credentials['DB_USER'],
      $credentials['DB_PASS'],
    ];
  }
}
