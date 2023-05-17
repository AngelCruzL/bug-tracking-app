<?php require_once __DIR__ . '/../vendor/autoload.php';

  use App\Entity\BugReport;
  use App\Exception\BadRequestException;
  use App\Helpers\App;
  use App\Helpers\DbQueryBuilderFactory;
  use App\Logger\Logger;
  use App\Repository\BugReportRepository;

  if (isset($_POST['add'])) {
    $reportType = $_POST['reportType'];
    $message = $_POST['message'];
    $email = $_POST['email'];
    $link = $_POST['link'];
    $is_test = $_POST['is_test'] ?? false;
    $logger = new Logger;

    $bugReport = new BugReport;
    $bugReport->setReportType($reportType);
    $bugReport->setMessage($message);
    $bugReport->setEmail($email);
    $bugReport->setLink($link);

    try {
      $application = new App;
      if ($is_test) {
        $queryBuilder = DbQueryBuilderFactory::make(
          'database',
          'pdo',
          ['DB_NAME' => 'bug_app_testing']
        );
      } else {
        $queryBuilder = DbQueryBuilderFactory::make();
      }

      $repository = new BugReportRepository($queryBuilder);
      $newReport = $repository->create($bugReport);
    } catch (Throwable $e) {
      $logger->critical($e->getMessage(), ['exception' => $e]);
      throw new BadRequestException($e->getMessage(), [$e], 400);
    }

    $logger->info('New report created', [
      'id' => $newReport->getId(),
      'report_type' => $newReport->getReportType(),
      'message' => $newReport->getMessage(),
      'email' => $newReport->getEmail(),
      'link' => $newReport->getLink()
    ]);
  }