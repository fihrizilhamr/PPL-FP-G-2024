CREATE DATABASE IF NOT EXISTS travel_booking;

USE travel_booking;

CREATE TABLE registered_customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,
    gender BOOLEAN NOT NULL,
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
    title VARCHAR(255),
    description TEXT,
    datetime DATETIME,
    FOREIGN KEY (user_id) REFERENCES registered_customer(id)
);

INSERT INTO ticket (name, price, status, description) VALUES
('Penerbangan ke Bali', 1500000.00, 1, 'Penerbangan langsung ke Bali'),
('Penginapan di Yogyakarta', 800000.00, 1, 'Penginapan 3 malam di hotel bintang 4 di Yogyakarta'),
('Paket Wisata di Lombok', 1200000.00, 1, 'Paket wisata mengelilingi keindahan alam Lombok'),
('Wisata Bahari di Raja Ampat', 2500000.00, 1, 'Paket liburan menyusuri keindahan bawah laut Raja Ampat');
