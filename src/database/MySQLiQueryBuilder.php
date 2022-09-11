<?php

namespace App\Database;

use App\Database\QueryBuilder;
use InvalidArgumentException;

class MySQLiQueryBuilder extends QueryBuilder
{
  private $resultSet;
  private $results;

  const PARAM_TYPE_INT = 'i';
  const PARAM_TYPE_STRING = 's';
  const PARAM_TYPE_DOUBLE = 'd';

  public function get(): QueryBuilder
  {
    if (!$this->resultSet) {
      $this->resultSet = $this->statement->get_result();
      $this->results = $this->resultSet->fetch_all(MYSQLI_ASSOC);
    }

    return $this->results;
  }

  public function count(): QueryBuilder
  {
    if (!$this->resultSet) {
      $this->get();
    }

    return $this->resultSet ? $this->resultSet->num_rows : false;
  }

  public function lastInsertedId(): QueryBuilder
  {
    return $this->connection->insert_id;
  }

  public function prepare($query): QueryBuilder
  {
    return $this->connection->prepare($query);
  }

  public function execute($statement): QueryBuilder
  {
    if (!$statement) {
      throw new InvalidArgumentException('MySQLi statement is not valid');
    }

    if ($this->bindings) {
      $bindings = $this->parseBindings($this->bindings);
      $reflectionObj = new \ReflectionClass('mysqli_stmt');
      $method = $reflectionObj->getMethod('bind_param');
      $method->invokeArgs($statement, $bindings);
    }

    $statement->execute();
    $this->bindings = [];
    $this->placeholders = [];

    return $statement;
  }

  private function parseBindings(array $params): array
  {
    $bindings = [];
    $paramsCount = count($params);

    if ($paramsCount === 0) {
      return $this->bindings;
    }

    $bindingTypes = $this->parseBindingTypes();
    $bindings[] = &$bindingTypes;

    for ($i = 0; $i < $paramsCount; $i++) {
      $bindings[] = &$params[$i];
    }

    return $bindings;
  }

  public function parseBindingTypes()
  {
    $bindingTypes = [];

    foreach ($this->bindings as $binding) {
      if (is_int($binding)) $bindingTypes[] = self::PARAM_TYPE_INT;
      if (is_string($binding)) $bindingTypes[] = self::PARAM_TYPE_STRING;
      if (is_float($binding)) $bindingTypes[] = self::PARAM_TYPE_DOUBLE;
    }

    return implode('', $bindingTypes);
  }

  public function fetchInto($className): array
  {
    $results = [];
    $this->resultSet = $this->statement->get_result();

    while ($row = $this->resultSet->fetch_object($className)) {
      $results[] = $row;
    }

    return $this->results = $results;
  }
}
