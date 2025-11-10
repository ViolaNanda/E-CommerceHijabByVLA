CREATE DATABASE IF NOT EXISTS hijabbyvla CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE hijabbyvla;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','staff') DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  motif VARCHAR(100) DEFAULT NULL,
  size VARCHAR(50) DEFAULT NULL,
  price INT NOT NULL,
  stock INT DEFAULT 0,
  rating DECIMAL(3,2) DEFAULT 0,
  image VARCHAR(255) DEFAULT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(200) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  address TEXT NOT NULL,
  total INT NOT NULL,
  status ENUM('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL,
  price INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS promos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NOT NULL UNIQUE,
  description VARCHAR(255),
  discount_type ENUM('percent','fixed') DEFAULT 'percent',
  discount_value DECIMAL(10,2) NOT NULL,
  active TINYINT(1) DEFAULT 1,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert example admin (replace hash with real password hash)
INSERT INTO users (name, email, password_hash, role) VALUES ('Admin','admin@hijabby.test','$2y$10$EXAMPLEHASH_REPLACE_ME', 'admin');
