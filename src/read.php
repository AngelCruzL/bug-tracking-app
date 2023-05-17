<?php

  use App\Helpers\DbQueryBuilderFactory;
  use App\Repository\BugReportRepository;

  $queryBuilder = DbQueryBuilderFactory::make();
  $repository = new BugReportRepository($queryBuilder);
  $bugReports = $repository->findAll();