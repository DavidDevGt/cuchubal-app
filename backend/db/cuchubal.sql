CREATE DATABASE IF NOT EXISTS cuchubal_app;

USE cuchubal_app;

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(255),
    address VARCHAR(255),
    payment_method VARCHAR(255),
    cuchubal_id INT, -- Agregado directamente en la creación de la tabla
    active TINYINT (1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    active TINYINT (1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE cuchubales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    amount DECIMAL(10, 2),
    start_date DATE,
    deadline DATE,
    active TINYINT (1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

-- Agregar las referencias de cuchubales en participants
ALTER TABLE participants
ADD FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id);

CREATE TABLE contributions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participant_id INT,
    cuchubal_id INT, -- Agregado directamente en la creación de la tabla
    amount DECIMAL(10, 2),
    date DATE,
    status VARCHAR(50),
    active TINYINT (1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (participant_id) REFERENCES participants (id),
    FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participant_id INT,
    cuchubal_id INT, -- Agregado directamente en la creación de la tabla
    amount DECIMAL(10, 2),
    date DATE,
    status VARCHAR(50),
    active TINYINT (1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (participant_id) REFERENCES participants (id),
    FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id)
);

CREATE TABLE payment_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuchubal_id INT,
    participant_id INT,
    scheduled_date DATE,
    amount DECIMAL(10, 2),
    status VARCHAR(50),
    notes TEXT, -- Agregado directamente en la creación de la tabla
    payment_date DATE, -- Agregado directamente
    payment_reference VARCHAR(255), -- Agregado directamente
    payment_method VARCHAR(50), -- Agregado directamente
    payment_confirmed TINYINT(1) DEFAULT 0, -- Agregado directamente
    active TINYINT (1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cuchubal_id) REFERENCES cuchubales (id),
    FOREIGN KEY (participant_id) REFERENCES participants (id)
);


-- VISTAS

# PROGRAMACIÓN DE PAGOS

CREATE VIEW view_payment_schedule AS
SELECT 
    ps.id,
    ps.cuchubal_id,
    ps.participant_id,
    p.name AS participant_name,
    ps.scheduled_date,
    ps.amount,
    ps.status,
    ps.notes,
    ps.payment_date,
    ps.payment_reference,
    ps.payment_method,
    ps.payment_confirmed
FROM payment_schedule ps
JOIN participants p ON ps.participant_id = p.id
WHERE ps.active = 1;


# DETALLES DE UN CUCHUBAL

CREATE VIEW view_cuchubal_details AS
SELECT 
    c.id,
    c.name,
    c.description,
    c.amount,
    c.start_date,
    c.deadline,
    u.username AS created_by,
    c.created_at,
    c.updated_at
FROM cuchubales c
JOIN users u ON c.user_id = u.id
WHERE c.active = 1;


# HISTORIAL DE PAGOS DE UN PARTICIPANTE

CREATE VIEW view_participant_payment_history AS
SELECT 
    p.id AS payment_id,
    p.participant_id,
    pa.name AS participant_name,
    p.cuchubal_id,
    c.name AS cuchubal_name,
    p.amount,
    p.date,
    p.status
FROM payments p
JOIN participants pa ON p.participant_id = pa.id
JOIN cuchubales c ON p.cuchubal_id = c.id
WHERE p.active = 1;
