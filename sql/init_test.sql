CREATE DATABASE IF NOT EXISTS bug_app;

USE bug_app;

CREATE TABLE IF NOT EXISTS reports
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    report_type VARCHAR(50)  NOT NULL,
    message     TEXT         NOT NULL,
    link        VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE DATABASE IF NOT EXISTS bug_app_testing;

USE bug_app_testing;

CREATE TABLE IF NOT EXISTS reports
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    report_type VARCHAR(50)  NOT NULL,
    message     TEXT         NOT NULL,
    link        VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);