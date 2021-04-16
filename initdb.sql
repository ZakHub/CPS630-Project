-- Execute using "SOURCE initdb.sql;"

DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS OrderedItem;
DROP TABLE IF EXISTS OrderInfo;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Store;
DROP TABLE IF EXISTS JoyRide;
DROP TABLE IF EXISTS LuxuryCar;
DROP TABLE IF EXISTS Racer;
DROP TABLE IF EXISTS Trip;
DROP TABLE IF EXISTS Car;
DROP TABLE IF EXISTS UserInfo;

CREATE TABLE UserInfo (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	firstName VARCHAR(255) NOT NULL,
	lastName VARCHAR(255) NOT NULL,
	phoneNumber VARCHAR(15) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	address VARCHAR(255) NOT NULL,
	salt VARCHAR(16) NOT NULL,
	passwrd VARCHAR(255) NOT NULL CHECK (passwrd <> ''),
	balance DOUBLE DEFAULT 0.00
);

CREATE TABLE Car (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	model VARCHAR(255) NOT NULL CHECK (model <> ''),
	rate DOUBLE DEFAULT 1.00
);

CREATE TABLE Trip (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	fromLat DOUBLE NOT NULL,
	fromLng DOUBLE NOT NULL,
	toLat DOUBLE NOT NULL,
	toLng DOUBLE NOT NULL,
	distance DOUBLE NOT NULL,
	carId INT UNSIGNED,
	price DOUBLE,
	fulfillmentDate DATE DEFAULT NULL,
	FOREIGN KEY (carId) REFERENCES Car(id)
);

CREATE TABLE Racer (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	racerName VARCHAR(255) NOT NULL CHECK (racerName <> ''),
	country VARCHAR(255) NOT NULL CHECK (country <> '')
);

CREATE TABLE LuxuryCar (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	model VARCHAR(255) NOT NULL CHECK (model <> ''),
	rate DOUBLE DEFAULT 1.00
);

CREATE TABLE JoyRide (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	vehicleId INT UNSIGNED NOT NULL,
	driverId INT UNSIGNED NOT NULL,
	distance DOUBLE NOT NULL,
	price DOUBLE NOT NULL,
	FOREIGN KEY (vehicleId) REFERENCES LuxuryCar(id),
	FOREIGN KEY (driverId) REFERENCES Racer(id)
);

CREATE TABLE Store (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	storeName VARCHAR(255) NOT NULL CHECK (storeName <> ''),
	lat DOUBLE NOT NULL,
	lng DOUBLE NOT NULL
);

CREATE TABLE Product (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(255) NOT NULL CHECK (description <> ''),
	storeId INT UNSIGNED,
	price DOUBLE NOT NULL,
	FOREIGN KEY (storeId) REFERENCES Store(id)
);

CREATE TABLE OrderInfo (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	orderDate DATE NOT NULL,
	price DOUBLE NOT NULL,
	userId INT UNSIGNED NOT NULL,
	FOREIGN KEY (userId) REFERENCES UserInfo(id)
);

CREATE TABLE OrderedItem (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	orderId INT UNSIGNED,
	tripId INT UNSIGNED,
	productId INT UNSIGNED,
	joyrideId INT UNSIGNED,
	FOREIGN KEY (orderId) REFERENCES OrderInfo(id),
	FOREIGN KEY (tripId) REFERENCES Trip(id),
	FOREIGN KEY (productId) REFERENCES Product(id),
	FOREIGN KEY (joyrideId) REFERENCES JoyRide(id)
);

CREATE TABLE Review (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	rating INT UNSIGNED NOT NULL CHECK(0 <= rating AND rating <= 10),
	feedback TEXT NOT NULL CHECK(feedback <> ''),
	orderId INT UNSIGNED NOT NULL UNIQUE,
	userId INT UNSIGNED NOT NULL,
	FOREIGN KEY (orderId) REFERENCES OrderInfo(id),
	FOREIGN KEY (userId) REFERENCES UserInfo(id)
);
