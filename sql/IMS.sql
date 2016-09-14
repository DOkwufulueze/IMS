CREATE DATABASE IF NOT EXISTS ims;
use ims;

CREATE TABLE IF NOT EXISTS inventory (
  id int(11) NOT NULL AUTO_INCREMENT,
  item varchar(100) NOT NULL,
  qtyleft int(11) NOT NULL,
  qty_sold int(11) NOT NULL,
  price int(11) NOT NULL,
  sales int(11) NOT NULL,
  date date,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS product_codes (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_id int(11),
  code char(20) NOT NULL,
  expiry_date CHAR(10),
  sold char(1),
  expired char(1),
  disposed_of char(1),
  date date,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS sales (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_id int(11) NOT NULL,
  qty int(11) NOT NULL,
  date varchar(30) NOT NULL,
  sales int(11) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS user (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

--
-- Dumping data for table user
--

INSERT INTO user (username, password) VALUES
('dan', md5('dan')),
('andrew', md5('andrew'));
