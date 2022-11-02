<?php

  namespace App\Repository;

  class BugReportRepository extends Repository
  {
    protected static string $table = 'bug_reports';
    protected static $className = BugReport::class;
  }
