<?php

  require_once __DIR__ . '/../../vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
  $dotenv->safeLoad();

  return [
    'pdo' => [
      'DB_DRIVER' => $_ENV['DB_DRIVER'],
      'DB_HOST' => $_ENV['DB_HOST'],
      'DB_PORT' => $_ENV['DB_PORT'],
      'DB_NAME' => $_ENV['DB_NAME'],
      'DB_USER' => $_ENV['DB_USER'],
      'DB_PASS' => $_ENV['DB_PASS'],
      'default_fetch' => PDO::FETCH_OBJ,
    ],
    'mysqli' => [
      'DB_HOST' => $_ENV['DB_HOST'],
      'DB_PORT' => $_ENV['DB_PORT'],
      'DB_NAME' => $_ENV['DB_NAME'],
      'DB_USER' => $_ENV['DB_USER'],
      'DB_PASS' => $_ENV['DB_PASS'],
      'default_fetch' => MYSQLI_ASSOC,
    ]
  ];
