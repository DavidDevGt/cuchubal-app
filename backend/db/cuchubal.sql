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
        amount DECIMAL(10, 2),
        date DATE,
        status VARCHAR(50), -- Por ejemplo: 'No pagado', 'Parcial', 'Completado'
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (participant_id) REFERENCES participants (id)
    );

CREATE TABLE
    payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        participant_id INT,
        amount DECIMAL(10, 2),
        date DATE,
        status VARCHAR(50), -- Por ejemplo: 'No pagado', 'Parcial', 'Completado'
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (participant_id) REFERENCES participants (id)
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

CREATE TABLE
    cuchubales (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        amount DECIMAL(10, 2),
        start_date DATE,
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id)
    );

ALTER TABLE participants
ADD COLUMN cuchubal_id INT,
ADD FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id);

ALTER TABLE contributions
ADD COLUMN cuchubal_id INT,
ADD FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id);

ALTER TABLE payments
ADD COLUMN cuchubal_id INT,
ADD FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id);

CREATE TABLE
    payment_schedule (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cuchubal_id INT,
        participant_id INT,
        scheduled_date DATE,
        amount DECIMAL(10, 2),
        status VARCHAR(50), -- Por ejemplo: 'No pagado', 'Parcial', 'Completado'
        active TINYINT (1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id),
        FOREIGN KEY (participant_id) REFERENCES participants (id)
    );