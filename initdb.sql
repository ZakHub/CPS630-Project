-- Execute using "SOURCE initdb.sql;"

START TRANSACTION;

DROP TABLE IF EXISTS OrderedItem;
DROP TABLE IF EXISTS OrderInfo;
DROP TABLE IF EXISTS UserInfo;
DROP TABLE IF EXISTS Trip;
DROP TABLE IF EXISTS Car;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Store;

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

CREATE TABLE Car (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	model VARCHAR(255) NOT NULL CHECK (model <> ''),
	rate DOUBLE DEFAULT 1.00
	-- car code
	-- availability code
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
	FOREIGN KEY (carId) REFERENCES Car(id)
);

-- CREATE TABLE UserInfo (
	-- id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	-- firstName VARCHAR(255) NOT NULL,
	-- lastName VARCHAR(255) NOT NULL,
	-- phoneNumber VARCHAR(15) NOT NULL,
	-- email VARCHAR(255) NOT NULL,
	-- address VARCHAR(255) NOT NULL,
	-- --cityCode INT NOT NULL, -- what is this supposed to do?
	-- --loginId INT NOT NULL, -- not sure what this is for either
	-- --passwrd VARCHAR(255) NOT NULL
	-- balance DOUBLE DEFAULT 0.00
-- );

CREATE TABLE UserInfo (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	firstName VARCHAR(255) NOT NULL,
	lastName VARCHAR(255) NOT NULL,
	phoneNumber VARCHAR(15) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	address VARCHAR(255) NOT NULL,
	passwrd VARCHAR(255) NOT NULL CHECK (passwrd <> ''),
	balance DOUBLE DEFAULT 0.00
);

CREATE TABLE Review (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	feedback VARCHAR(65532) NOT NULL CHECK(feedback <> ''),
	userId UNSIGNED INT NOT NULL,
	FOREIGN KEY (userId) REFERENCES UserInfo(id)
);

-- CREATE TABLE OrderInfo (
	-- id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	-- orderDate DATE NOT NULL,
	-- fulfilledDate DATE NOT NULL,
	-- price DOUBLE NOT NULL,
	-- --paymentId -- not sure what this is for
	-- userId INT UNSIGNED,	-- add foreign key
	-- tripId INT UNSIGNED,	-- add foreign key
	-- flowerId INT UNSIGNED	-- add foreign key
-- );

CREATE TABLE OrderInfo (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	orderDate DATE NOT NULL,
	fulfillmentDate DATE DEFAULT NULL,
	price DOUBLE NOT NULL,
	userId INT UNSIGNED NOT NULL,
	FOREIGN KEY (userId) REFERENCES UserInfo(id)
);

CREATE TABLE OrderedItem (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	orderId INT UNSIGNED,
	tripId INT UNSIGNED,
	productId INT UNSIGNED,
	FOREIGN KEY (orderId) REFERENCES OrderInfo(id),
	FOREIGN KEY (tripId) REFERENCES Trip(id),
	FOREIGN KEY (productId) REFERENCES Product(id)
);

COMMIT;
