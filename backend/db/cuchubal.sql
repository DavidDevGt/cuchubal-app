CREATE DATABASE IF NOT EXISTS cuchubal_app;

USE cuchubal_app;

CREATE TABLE
    participants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        contact VARCHAR(255),
        address VARCHAR(255),
        payment_method VARCHAR(255),
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE
    contributions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        participant_id INT,
        amount DECIMAL(10,2),
        date DATE,
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (participant_id) REFERENCES participants(id)
    );

CREATE TABLE
    payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        participant_id INT,
        amount DECIMAL(10,2),
        date DATE,
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (participant_id) REFERENCES participants(id)
    );

CREATE TABLE
    users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );