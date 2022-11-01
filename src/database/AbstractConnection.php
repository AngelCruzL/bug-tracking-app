<?php

namespace App\Database;

use App\Exception\MissingArgumentException;
use mysqli;
use PDO;

abstract class AbstractConnection
{
  protected PDO|mysqli $connection;
  protected array $credentials;

  const REQUIRED_CONNECTION_KEYS = [];

  public function __construct(array $credentials)
  {
    $this->credentials = $credentials;
    if (!$this->credentialsHaveRequiredKeys($this->credentials)) {
      throw new MissingArgumentException(
        sprintf(
          'Database connection credentials are not mapped correctly, required key: %s',
          implode(',', static::REQUIRED_CONNECTION_KEYS)
        )
      );
    }
  }

  private function credentialsHaveRequiredKeys(array $providedKeys): bool
  {
    $matches = array_intersect(static::REQUIRED_CONNECTION_KEYS, array_keys($providedKeys));
    return count($matches) === count(static::REQUIRED_CONNECTION_KEYS);
  }

  abstract protected function parseCredentials(array $credentials): array;
}
