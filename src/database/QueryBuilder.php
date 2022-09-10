<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Exception\NotFoundException;

abstract class QueryBuilder
{
  protected $connection;
  protected $table;
  protected $statement;
  protected $fields;
  protected $placeholders = [];
  protected $bindings = [];
  protected $operation = self::DML_TYPE_SELECT;

  const OPERATORS = ['=', '>=', '>', '<=', '<', '<>'];
  const PLACEHOLDER = '?';
  const COLUMNS = '*';
  const DML_TYPE_SELECT = 'SELECT';
  const DML_TYPE_INSERT = 'INSERT';
  const DML_TYPE_UPDATE = 'UPDATE';
  const DML_TYPE_DELETE = 'DELETE';

  use Query;

  public function __construct(DatabaseConnectionInterface $databaseConnection)
  {
    $this->connection = $databaseConnection->getConnection();
  }

  public function table(string $table): QueryBuilder
  {
    $this->table = $table;
    return $this;
  }

  public function where(
    string $column,
    string $operator = self::OPERATORS[0],
    string|null $value = null
  ): QueryBuilder {
    if (!in_array($operator, self::OPERATORS)) {
      if ($value === null) {
        $value = $operator;
        $operator = self::OPERATORS[0];
      } else {
        throw new NotFoundException('Invalid operator', ['operator' => $operator]);
      }
    }

    $this->parseWhere([$column => $value], $operator);
    $query = $this->prepare($this->getQuery($this->operation));
    $this->statement = $this->execute($query);
    return $this;
  }

  private function parseWhere(array $conditions, string $operator): QueryBuilder
  {
    foreach ($conditions as $key => $value) {
      $this->placeholders[] = sprintf('%s %s %s', $key, $operator, self::PLACEHOLDER);
      $this->bindings[] = $value;
    }

    return $this;
  }

  public function select(string $fields = self::COLUMNS): QueryBuilder
  {
    $this->operation = self::DML_TYPE_SELECT;
    $this->fields = $fields;
    return $this;
  }

  abstract public function get();
  abstract public function count();
  abstract public function lastInsertedId();
  abstract public function prepare($query);
  abstract public function execute($statement);
  abstract public function fetchInto($className);
}
