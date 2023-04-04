CREATE DATABASE IF NOT EXISTS many_minds;

USE many_minds;

ALTER USER 'admin'@'%' IDENTIFIED BY 'new_password123';

GRANT ALL PRIVILEGES ON many_minds.* TO 'admin'@'%';

FLUSH PRIVILEGES;

CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  permission_level ENUM('admin', 'collaborator', 'user', 'supplier') NOT NULL,
  PRIMARY KEY (user_id)
);

CREATE TABLE addresses (
  address_id INT NOT NULL AUTO_INCREMENT,
  zip_code VARCHAR(10) NOT NULL,
  street VARCHAR(255) NOT NULL,
  number VARCHAR(10) NOT NULL,
  complement VARCHAR(255),
  city VARCHAR(255) NOT NULL,
  state VARCHAR(2) NOT NULL,
  PRIMARY KEY (address_id)
);

CREATE TABLE collaborators (
  collaborator_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  user_id INT NOT NULL,
  active BOOLEAN NOT NULL,
  address_id INT NOT NULL,
  PRIMARY KEY (collaborator_id),
  FOREIGN KEY (address_id) REFERENCES addresses(address_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE collaborator_addresses (
  collaborator_id INT NOT NULL,
  address_id INT NOT NULL,
  PRIMARY KEY (collaborator_id, address_id),
  FOREIGN KEY (collaborator_id) REFERENCES collaborators(collaborator_id),
  FOREIGN KEY (address_id) REFERENCES addresses(address_id)
);

CREATE TABLE products (
  product_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  stock_quantity INT NOT NULL,
  active BOOLEAN NOT NULL,
  PRIMARY KEY (product_id)
);

CREATE TABLE orders (
  order_id INT NOT NULL AUTO_INCREMENT,
  observations TEXT,
  user_id INT NOT NULL,
  status ENUM('active', 'finished') NOT NULL,
  PRIMARY KEY (order_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_items (
  order_item_id INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  supplier_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (order_item_id),
  FOREIGN KEY (order_id) REFERENCES orders(order_id),
  FOREIGN KEY (supplier_id) REFERENCES collaborators(collaborator_id),
  FOREIGN KEY (product_id) REFERENCES products(product_id)
);
