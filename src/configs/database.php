<?php

return [
  'pdo' => [
    'DB_DRIVER' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '3306',
    'DB_NAME' => 'bug_app',
    'DB_USER' => 'root',
    'DB_PASS' => 'root',
    'default_fetch' => PDO::FETCH_OBJ,
  ],
  'mysqli' => [
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '3306',
    'DB_NAME' => 'bug_app',
    'DB_USER' => 'root',
    'DB_PASS' => 'root',
    'default_fetch' => MYSQLI_ASSOC,
  ]
];
