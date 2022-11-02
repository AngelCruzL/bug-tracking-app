<?php

  namespace Tests\Units;

  use App\Database\QueryBuilder;
  use App\Helpers\DbQueryBuilderFactory;
  use PHPUnit\Framework\TestCase;

  class RepositoryTest extends TestCase
  {
    /** @var QueryBuilder $aueryBuilder */
    private $queryBuilder;
    private $bugReportRepository;

    protected function setUp(): void
    {
      $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['DB_NAME' => 'bug_app_testing']);
      $this->queryBuilder->beginTransaction();

      $this->bugReportRepository = new BugReportRepository($this->queryBuilder);
      parent::setUp();
    }

    private function createBugReport(): BugReport
    {
      $bugReport = new BugReport();
      $bugReport
        ->setReportType('Type 2')
        ->setLink('https://testing-link.com')
        ->setMessage('This is a dummy message')
        ->setEmail('test@test.com');
      return $this->bugReportRepository->create($bugReport);
    }

    public function testItCanCreateRecordWithEntity()
    {
      $newBugReport = $this->createBugReport();
      self::assertInstanceOf(BugReport::class, $newBugReport);
      self::assertSame('Type 2', $newBugReport->getReportType());
      self::assertSame('https://testing-link.com', $newBugReport->getLink());
      self::assertSame('This is a dummy message', $newBugReport->getMessage());
      self::assertSame('test@test.com', $newBugReport->getEmail());
    }

    public function testItCanUpdateAGivenEntry()
    {
      $newBugReport = $this->createBugReport();
      $bugReport = $this->bugReportRepository->find($newBugReport->getId());
      $bugReport
        ->setMessage('This is a message from update method')
        ->setLink('https://github.com/angelcl');
      $updatedReport = $this->bugReportRepository->update($bugReport);
      self::assertInstanceOf(BugReport::class, $newBugReport);
      self::assertSame('https://github.com/angelcl', $newBugReport->getLink());
      self::assertSame('This is a message from update method', $newBugReport->getMessage());
    }

    public function testItCanDeleteTheGivenEntity()
    {
      $newBugReport = $this->createBugReport();
      $this->bugReportRepository->delete($newBugReport);
      $bugReport = $this->bugReportRepository->find($newBugReport->getId());
      self::assertNull($bugReport);
    }

    public function tearDown(): void
    {
      $this->queryBuilder->rollback();
      parent::tearDown();
    }
  }
