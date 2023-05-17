<?php

  namespace Functional;

  use App\Helpers\HttpClient;
  use PHPUnit\Framework\TestCase;

  class HomePageTest extends TestCase
  {
    public function testItCanVisitHomePageAndSeeRelevantData()
    {
      $client = new HttpClient;
      $response = $client->get('http://localhost:3000/index.php');
      $response = json_decode($response, true);
      self::assertEquals(200, $response['status_code']);
      self::assertStringContainsString(
        '<title>Bug App Tracker</title>',
        $response['content']
      );
      self::assertStringContainsString(
        '<h2>Manage <b>Bug Reports</b></h2>',
        $response['content']
      );
    }
  }