USE yeticave;

INSERT INTO category
(id, cat_name, is_deleted)
VALUES
('0', 'Доски и лыжи', '0'),
('1','Крепления','0'),
('2','Ботинки','0'),
('3','Одежда','0'),
('4','Инструменты','0'),
('5','Разное','0');

INSERT INTO users
(id, registration_date, email, name, password, avatar, contacts)
VALUES
('0','2017-12-03 17:43:01', 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka','#','+781223904230' ),
('1','2017-12-03 17:43:02', 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa','#','+781223345345' ),
('2','2017-12-03 17:43:03', 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW','#','+781224325903' );

INSERT INTO lot
(id, user_id, category_id, creation_date, name, description, photo, starting_price, end_date, step)
VALUES
('0', '0', '0', '2017-12-03 17:44:01', '2014 Rossignol District Snowboard', 'Клёвый борд, без царапин, почти новый', 'img/lot-1.jpg', '10999', '2018-01-03 17:44:01','300'),
('1', '2', '0', '2017-12-03 17:45:01', 'DC Ply Mens 2016/2017 Snowboard', 'Два сезона откатал, немного покоцаный. Норм борд!', 'img/lot-2.jpg', '159999', '2018-01-03 17:45:01','1000'),
('2', '1', '1', '2017-12-03 17:46:01', 'Крепления Union Contact Pro 2015 года пазмер L/XL', 'Всё работает, ничего не поломано', 'img/lot-3.jpg', '8000', '2018-01-03 17:46:01','200'),
('3', '0', '2', '2017-12-03 17:47:01', 'Ботинки для сноуборда DC Mutiny Charocal', 'Боты круть, и совсемь не пахнут.', 'img/lot-4.jpg','10999', '2018-01-03 17:47:01','400'),
('4', '1', '3', '2017-12-03 17:48:01', 'Куртка для сноуборда DC Mutiny Charocal', 'Курточка моя так хороше сидит на мне).', 'img/lot-5.jpg','7500', '2018-01-03 17:48:01','200'),
('5', '2', '3', '2017-12-03 17:49:01', 'Маска Oakley Canopy', 'Надел маску, и тебя не узнать.', 'img/lot-6.jpg','7500', '2018-01-03 17:49:01','300');

INSERT INTO bet
(id, user_id,lot_id, reg_date, bet_value)
VALUES
('0','1','2','2017-12-03 18:46:01','8200'),
('1','0','2','2017-12-03 19:46:01','8400'),
('2','2','2','2017-12-03 20:46:01','8600');

SELECT cat_name
FROM category;

SELECT l.name, l.starting_price, l.photo, MAX(b.bet_value), COUNT(b.lot_id),c.cat_name
FROM lot l
JOIN category c
ON
l.category_id=c.id
JOIN bet b
ON l.id=b.lot_id
WHERE end_date > CURRENT_TIME
GROUP BY b.lot_id
ORDER BY l.creation_date DESC;

SELECT name, description, c.cat_name
FROM lot
JOIN category c
ON category_id=c.id
WHERE name='Куртка для сноуборда DC Mutiny Charocal' OR description LIKE '%борд%';

UPDATE lot SET name='Маска Oakley Canopy' WHERE id = '5';

SELECT l.name, b.bet_value, c.cat_name
FROM lot l
JOIN bet b
ON l.id=b.lot_id
JOIN category c
ON
l.category_id=c.id
WHERE end_date > CURRENT_TIME
AND l.id='2'
ORDER BY b.reg_date DESC;
