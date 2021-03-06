START TRANSACTION;

INSERT INTO Car
	(model, rate)
VALUES
	('2003 Lexus RX330', 4.00),
	('2001 Toyota Corolla', 1.33);

INSERT INTO Store
	(storeName, lat, lng)
VALUES
	('Flower Power', 12, 12),
	('Circle-K', 20, 20);

INSERT INTO Product
	(description, storeId, price)
VALUES
	('Rose', 1, 4.00),
	('Orchid', 1, 2.33),
	('Excel Gum', 2, 1.00);

COMMIT;
