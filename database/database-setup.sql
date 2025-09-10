-- database create


CREATE DATABASE smilepoint;
USE smilepoint;


-- user table 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    points INT DEFAULT 0,
    profile_image VARCHAR(255),
    last_smile_date DATE,
    smile_count_today INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- smile table

CREATE TABLE smile_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    image_url VARCHAR(255),
    smile_score INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- smile challenge

CREATE TABLE smile_challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    badge_image VARCHAR(255),
    min_score INT DEFAULT 50
);


-- data inserting
INSERT INTO smile_challenges 
(name, start_date, end_date, badge_image) 
VALUES 
('Diwali Smile Festival', '2023-11-10', '2023-11-15', 'badges/diwali-2023.png');