<?php

namespace App\Database;

use App\Database\QueryBuilder;
use PDO;

class PDOQueryBuilder extends QueryBuilder
{
  public function get(): QueryBuilder
  {
    return $this->statement->fetchAll();
  }

  public function count(): QueryBuilder
  {
    return $this->statement->rowCount();
  }

  public function lastInsertedId(): QueryBuilder
  {
    return $this->connection->lastInsertId();
  }

  public function prepare($query): QueryBuilder
  {
    return $this->connection->prepare($query);
  }

  public function execute($statement): QueryBuilder
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
}
