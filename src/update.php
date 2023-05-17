<?php require_once __DIR__ . '/../vendor/autoload.php';

  use App\Entity\BugReport;
  use App\Exception\BadRequestException;
  use App\Helpers\DbQueryBuilderFactory;
  use App\Logger\Logger;
  use App\Repository\BugReportRepository;
  use App\Helpers\App;

  if (isset($_POST['update'])) {
    $reportType = $_POST['reportType'];
    $message = $_POST['message'];
    $email = $_POST['email'];
    $link = $_POST['link'];
    $logger = new Logger;

    try {
      $application = new App;

      if ($_POST['is_test']) {
        $queryBuilder = DbQueryBuilderFactory::make(
          'database',
          'pdo',
          ['DB_NAME' => 'bug_app_testing']
        );
      } else {
        $queryBuilder = DbQueryBuilderFactory::make();
      }

      $repository = new BugReportRepository($queryBuilder);

      $bugReport = $repository->find((int) $_POST['report_id']);
      $bugReport->setReportType($reportType);
      $bugReport->setMessage($message);
      $bugReport->setEmail($email);
      $bugReport->setLink($link);

      $newReport = $repository->update($bugReport);
    } catch (Throwable $e) {
      $logger->critical($e->getMessage(), ['exception' => $e]);
      throw new BadRequestException($e->getMessage(), [$e], 400);
    }

    $logger->info('Bug report updated', [
      'id' => $newReport->getId(),
      'report_type' => $newReport->getReportType(),
      'message' => $newReport->getMessage(),
      'email' => $newReport->getEmail(),
      'link' => $newReport->getLink()
    ]);
  }