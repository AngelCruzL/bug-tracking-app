<?php

namespace Tests\Units;

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Database\PDOConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;
use App\Helpers\DbQueryBuilderFactory;
use PHPUnit\Framework\TestCase;
use QueryBuilder;

class QueryBuilderTest extends TestCase
{
  /** @var QueryBuilder $queryBuilder */
  private $queryBuilder;

  public function setUp(): void
  {
    $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['DB_NAME' => 'bug_app_testing']);
    $this->queryBuilder->getConnection()->beginTransaction();
    parent::setUp();
  }

  public function testItCanCreateRecords()
  {
    $id = $this->insertIntoTable();
    self::assertNotNull($id);
  }

  public function testItCanPerformRawQuery()
  {
    $result = $this->queryBuilder->raw('SELECT * FROM reports;')->get();
    self::assertNotNull($result);
  }

  public function testItCanPerformSelectQuery()
  {
    $id = $this->insertIntoTable();

    $result = $this->queryBuilder
      ->table('reports')
      ->select('*')
      ->where('id', $id)
      ->first();

    self::assertNotNull($result);
    self::assertSame($id, $result->id);
  }

  public function testItCanPerformSelectQueryWithMultipleWhereClause()
  {
    $id = $this->insertIntoTable();

    $result = $this->queryBuilder
      ->table('reports')
      ->select('*')
      ->where('id', $id)
      ->where('report_type', '=', 'Report Type 1')
      ->first();

    self::assertNotNull($result);
    self::assertSame($id, $result->id);
    self::assertSame('Report Type 1', $result->report_type);
  }

  public function tearDown(): void
  {
    $this->queryBuilder->getConnection()->rollback();
    parent::tearDown();
  }

  public function insertIntoTable(): int
  {
    $data = [
      'report_type' => 'Report Type 1',
      'message' => 'This is a test message',
      'link' => 'https://www.google.com',
      'email' => 'test@test.com',
      'created_at' => date('Y-m-d H:i:s'),
    ];
    $id = $this->queryBuilder->table('reports')->create($data);
    return (int)$id;
  }
}
