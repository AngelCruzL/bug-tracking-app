<?php

namespace App\Database;

use PDO;
use PDOStatement;

class PDOQueryBuilder extends QueryBuilder
{
  public function get(): array
  {
    return $this->statement->fetchAll();
  }

  public function count(): int
  {
    return $this->statement->rowCount();
  }

  public function lastInsertedId(): string
  {
    return $this->connection->lastInsertId();
  }

  public function prepare($query): PDOStatement
  {
    return $this->connection->prepare($query);
  }

  public function execute($statement): PDOStatement
  {
    $statement->execute($this->bindings);
    $this->bindings = [];
    $this->placeholders = [];
    return $statement;
  }

  public function fetchInto($className): array
  {
    return $this->statement->fetchAll(PDO::FETCH_CLASS, $className);
  }

  public function beginTransaction()
  {
    $this->connection->beginTransaction();
  }

  public function affected(): int
  {
    return $this->count();
  }
}
