<?php

  namespace App\Repository;

  use App\Entity\BugReport;

  class BugReportRepository extends Repository
  {
    protected static string $table = 'reports';
    protected static $className = BugReport::class;
  }
