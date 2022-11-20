<?php

  namespace Tests\Functional;

  use App\Database\QueryBuilder;
  use App\Entity\BugReport;
  use App\Helpers\DbQueryBuilderFactory;
  use App\Helpers\HttpClient;
  use App\Repository\BugReportRepository;
  use PHPUnit\Framework\TestCase;

  class CrudTest extends TestCase
  {
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;
    /** @var BugReportRepository $repository */
    private $repository;
    /** @var HttpClient $client */
    private $client;

    protected function setUp(): void
    {
      $this->queryBuilder = DbQueryBuilderFactory::make();
      $this->repository = new BugReportRepository($this->queryBuilder);
      $this->client = new HttpClient();
      parent::setUp();
    }

    public function testItCanCreateReportUsingPostRequest(): BugReport
    {
      $postData = $this->getPostData(['add' => true]);
      $response = $this->client->post('http://localhost:3000/Src/add.php', $postData);
      $response = json_decode($response, true);
      self::assertEquals(200, $response['status_code']);

      $result = $this->repository->findBy([
        ['report_type', '=', 'Bug'],
        ['email', '=', 'test@test.com'],
        ['link', '=', 'https://example.com']
      ]);

      /** @var BugReport $bugReport */
      $bugReport = $result[0] ?? [];

      self::assertInstanceOf(BugReport::class, $bugReport);
      self::assertSame('Bug', $bugReport->getReportType());
      self::assertSame('test@test.com', $bugReport->getEmail());
      self::assertEquals('https://example.com', $bugReport->getLink());

      return $bugReport;
    }

    /** @depends testItCanCreateReportUsingPostRequest */
    public function testItCanUpdateReportUsingPostRequest(BugReport $bugReport): BugReport
    {
      $postData = $this->getPostData([
        'update' => true,
        'message' => 'This is an updated test message',
        'link' => 'https://updated.example.com',
        'report_id' => $bugReport->getId()
      ]);
      $response = $this->client->post('http://localhost:3000/Src/update.php', $postData);
      $response = json_decode($response, true);
      self::assertEquals(200, $response['status_code']);

      /** @var BugReport $result */
      $result = $this->repository->find($bugReport->getId());

      self::assertInstanceOf(BugReport::class, $result);
      self::assertSame('This is an updated test message', $result->getMessage());
      self::assertEquals('https://updated.example.com', $result->getLink());

      return $bugReport;
    }

    /** @depends testItCanUpdateReportUsingPostRequest */
    public function testItCanDeleteReportUsingPostRequest(BugReport $bugReport)
    {
      $postData = [
        'delete' => true,
        'report_id' => $bugReport->getId()
      ];
      $response = $this->client->post('http://localhost:3000/Src/delete.php', $postData);
      $response = json_decode($response, true);
      self::assertEquals(200, $response['status_code']);

      /** @var BugReport $result */
      $result = $this->repository->find($bugReport->getId());

      self::assertNull($result);
    }

    private function getPostData(array $options): array
    {
      return array_merge([
        'reportType' => 'Bug',
        'message' => 'This is a test message',
        'email' => 'test@test.com',
        'link' => 'https://example.com',
      ], $options);
    }
  }