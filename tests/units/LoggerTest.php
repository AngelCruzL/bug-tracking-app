<?php

namespace Tests\Units;

use App\Contracts\LoggerInterface;
use App\Exception\InvalidLogLevelArgument;
use App\Helpers\App;
use App\Logger\Logger;
use App\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
  /** @var Logger $logger */
  private Logger $logger;

  public function setUp(): void
  {
    $this->logger = new Logger;
    parent::setUp();
  }

  public function testItImplementsTheLoggerInterface()
  {
    self::assertInstanceOf(LoggerInterface::class, $this->logger);
  }

  public function testItCanCreateDifferentTypesOfLogLevel()
  {
    $this->logger->info('This is an info log');
    $this->logger->error('This is an testing error log');
    $this->logger->log(LogLevel::ALERT, 'Testing alert log');
    $app = new App();

    $fileName = sprintf('%s/%s-%s.log', $app->getLogPath(), 'test', date('j.n.Y'));
    self::assertFileExists($fileName);

    $contentOfLogFile = file_get_contents($fileName);
    self::assertStringContainsString('This is an info log', $contentOfLogFile);
    self::assertStringContainsString('This is an testing error log', $contentOfLogFile);
    self::assertStringContainsString('Testing alert log', $contentOfLogFile);
    unlink($fileName);
    self::assertFileNotExists($fileName);
  }

  public function testItThrowsInvalidLogLevelArgumentExceptionWhenGivenAWrongLogLevel()
  {
    self::expectException(InvalidLogLevelArgument::class);
    $this->logger->log('wrongLogLevel', 'This is a wrong log level');
  }
}
