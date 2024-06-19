-- CREATE DATABASE IF NOT EXISTS travel_booking;

-- USE travel_booking;

CREATE TABLE registered_customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,
    gender CHAR(1) NOT NULL,
    phonenumber VARCHAR(15) NOT NULL
);

CREATE TABLE ticket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status BOOLEAN NOT NULL,
    description TEXT
);

CREATE TABLE ticket_purchase (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT,
    user_id INT,
    ticket_amount INT,
    datetime DATETIME,
    FOREIGN KEY (ticket_id) REFERENCES ticket(id),
    FOREIGN KEY (user_id) REFERENCES registered_customer(id)
);

CREATE TABLE review (
    id INT AUTO_INCREMENT PRIMARY KEY,
    destination_id INT,
    user_id INT,
    rating INT,
    description TEXT,
    image_path VARCHAR(255),
    datetime DATETIME,
    FOREIGN KEY (user_id) REFERENCES registered_customer(id)
);

CREATE TABLE destination (
    d_id INT AUTO_INCREMENT PRIMARY KEY,
    d_name VARCHAR(255) NOT NULL,
    d_description TEXT NOT NULL,
    d_picture VARCHAR(255)
);

CREATE TABLE payment (
    pm_id INT AUTO_INCREMENT PRIMARY KEY,
    pm_datetime DATETIME NOT NULL,
    pm_totlaprice DECIMAL(10, 2) NOT NULL
);

CREATE TABLE cart (
    c_id INT AUTO_INCREMENT PRIMARY KEY,
    c_datetime DATETIME NOT NULL,
    c_ticketamount INT NOT NULL,
    c_userid INT,
    c_ticketid INT,
    FOREIGN KEY (c_userid) REFERENCES registered_customer(id),
    FOREIGN KEY (c_ticketid) REFERENCES ticket(id)
);

CREATE TABLE business_partner (
    bp_id INT AUTO_INCREMENT PRIMARY KEY,
    bp_username VARCHAR(255) NOT NULL,
    bp_password VARCHAR(255) NOT NULL,
    bp_email VARCHAR(255) NOT NULL,
    bp_name VARCHAR(255) NOT NULL,
    bp_phonenumber VARCHAR(15) NOT NULL
);


INSERT INTO ticket (name, price, status, description) VALUES
('Penerbangan ke Bali', 1500000.00, 1, 'Penerbangan langsung ke Bali'),
('Penginapan di Yogyakarta', 800000.00, 1, 'Penginapan 3 malam di hotel bintang 4 di Yogyakarta'),
('Paket Wisata di Lombok', 1200000.00, 1, 'Paket wisata mengelilingi keindahan alam Lombok'),
('Wisata Bahari di Raja Ampat', 2500000.00, 1, 'Paket liburan menyusuri keindahan bawah laut Raja Ampat');

INSERT INTO business_partner (bp_username, bp_password, bp_email, bp_name, bp_phonenumber) VALUES
('partner1', 'password', 'partner1@example.com', 'Partner One', '123-456-7890'),
('partner2', 'password', 'partner2@example.com', 'Partner Two', '987-654-3210'),
('partner3', 'password', 'partner3@example.com', 'Partner Three', '456-789-0123');

