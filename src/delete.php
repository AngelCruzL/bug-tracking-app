<?php require_once __DIR__ . '/../vendor/autoload.php';

  use App\Exception\BadRequestException;
  use App\Helpers\DbQueryBuilderFactory;
  use App\Logger\Logger;
  use App\Repository\BugReportRepository;

  if (isset($_POST['delete'])) {
    $report_id = $_POST['report_id'];
    $is_test = $_POST['is_test'] ?? false;
    $logger = new Logger;

    try {

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
      $bugReport = $repository->find((int)$report_id);
      $repository->delete($bugReport);
    } catch (Throwable $e) {
      $logger->critical($e->getMessage(), ['exception' => $e]);
      throw new BadRequestException($e->getMessage(), [$e], 400);
    }

    $logger->info('Bug report deleted', [
      'id' => $bugReport->getId(),
      'report_type' => $bugReport->getReportType(),
      'message' => $bugReport->getMessage(),
      'email' => $bugReport->getEmail(),
      'link' => $bugReport->getLink()
    ]);
  }