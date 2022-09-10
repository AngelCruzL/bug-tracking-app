<?php

namespace Tests\Units;

use App\Database\PDOConnection;
use App\Database\QueryBuilder as DatabaseQueryBuilder;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
use QueryBuilder;

class QueryBuilderTest extends TestCase
{
  /** @var QueryBuilder $queryBuilder  */
  private $queryBuilder;

  public function setUp(): void
  {
    $pdo
      = new PDOConnection(
        Config::get('database', 'pdo'),
        ['database' => 'bug_app_testing']
      );

    $this->queryBuilder = new DatabaseQueryBuilder($pdo->connect());
    parent::setUp();
  }

  public function testItCanPerformSelectQuery()
  {
    $result = $this->queryBuilder
      ->table('reports')
      ->select('*')
      ->where('id', 1);
    // ->first();

    var_dump($result->query);
    exit;

    self::assertNotNull($result);
    self::assertSame(1, (int) $result->id);
  }

  public function testItCanPerformSelectQueryWithMultipleWhereClause()
  {
    $result = $this->queryBuilder
      ->table('reports')
      ->select('*')
      ->where('id', 1)
      ->where('report_type', '=', 'Report Type 1')
      ->first();

    self::assertNotNull($result);
    self::assertSame(1, (int) $result->id);
    self::assertSame('Report Type 1', $result->report_type);
  }
}
