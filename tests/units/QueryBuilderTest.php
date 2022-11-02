<?php

namespace Tests\Units;

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Database\PDOConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
use QueryBuilder;

class QueryBuilderTest extends TestCase
{
  /** @var QueryBuilder $queryBuilder */
  private $queryBuilder;

  public function setUp(): void
  {
    $credentials = array_merge(
      Config::get('database', 'mysqli'),
      ['DB_NAME' => 'bug_app_testing']
    );

    $pdo = new MySQLiConnection($credentials);

    $this->queryBuilder = new MySQLiQueryBuilder($pdo->connect());
    parent::setUp();
  }

  public function testItCanCreateRecords()
  {
    $data = [
      'report_type' => 'Report Type 1',
      'message' => 'This is a test message',
      'link' => 'https://www.google.com',
      'email' => 'test@test.com',
      'created_at' => date('Y-m-d H:i:s'),
    ];
    $id = $this->queryBuilder->table('reports')->create($data);
    self::assertNotNull($id);
  }

  public function testItCanPerformRawQuery()
  {
    $result = $this->queryBuilder->raw('SELECT * FROM reports;')->get();
    self::assertNotNull($result);
  }

  public function testItCanPerformSelectQuery()
  {
    $result = $this->queryBuilder
      ->table('reports')
      ->select('*')
      ->where('id', 1)
      ->first();

    self::assertNotNull($result);
    self::assertSame(1, (int)$result->id);
  }

  public function testItCanPerformSelectQueryWithMultipleWhereClause()
  {
    $result = $this->queryBuilder
      ->table('reports')
      ->select('*')
      ->where('id', 1)
      ->first();

    self::assertNotNull($result);
    self::assertSame(1, (int)$result->id);
    self::assertSame('Report Type 1', $result->report_type);
  }
}
