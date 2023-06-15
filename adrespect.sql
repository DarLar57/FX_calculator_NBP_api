SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE adrespect;

CREATE TABLE exchange_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no VARCHAR(50) NOT NULL,
    effectivedate DATE NOT NULL,
    currency VARCHAR(50) NOT NULL,
    code VARCHAR(11) NOT NULL,
    mid DOUBLE NOT NULL
);

CREATE TABLE currency_conversions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    effectivedate DATE NOT NULL,
    source_curr VARCHAR(255) NOT NULL,
    source_curr_code VARCHAR(255) NOT NULL,
    target_curr VARCHAR(255) NOT NULL,
    target_curr_code VARCHAR(255) NOT NULL,
    amount DECIMAL(16,2) NOT NULL   
);

COMMIT;