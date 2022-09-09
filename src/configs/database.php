<?php

return [
  'pdo' => [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'bug_app',
    'username' => 'root',
    'password' => 'root',
    'default_fetch' => PDO::FETCH_OBJ,
  ],
  'mysqli' => [
    'host' => 'localhost',
    'database' => 'bug_app',
    'username' => 'root',
    'password' => 'root',
    'default_fetch' => MYSQLI_ASSOC,
  ]
];
