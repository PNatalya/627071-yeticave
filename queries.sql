/*Заполнение таблицы категорий*/

INSERT INTO category(name)
values ("Доски и лыжи"),
("Крепления"),
("Ботинки"),
("Одежда"),
("Инструменты"),
("Разное");

/*Заполнение таблицы пользователи*/

INSERT INTO users (dt_add, name, password, avatar_path, contacts, email) values
(CURDATE(), 'Игнат','$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', 'img/avatar.jpg', '222-333-222', 'ignat.v@gmail.com'),
(CURDATE(), 'Леночка','$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', 'img/avatar.jpg', '222-333-222', 'kitty_93@li.ru'),
(CURDATE(), 'Руслан','$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'img/avatar.jpg', '222-333-222', 'warrior07@mail.ru');


/*Заполнение таблицы лоты*/

INSERT INTO lots (dt_add, name, description, img, rate, dt_close, step, user_id, category_id) values
(DATE_SUB(CURDATE(),INTERVAL 1 DAY), '2014 Rossignol District Snowboard','', 'img/lot-1.jpg', 10999, '2018-7-04',12000, 1, 1),
(DATE_SUB(CURDATE(),INTERVAL 2 DAY), 'DC Ply Mens 2016/2017 Snowboard','', 'img/lot-2.jpg', 159999, '2018-7-04',12000, 1, 1),
(DATE_SUB(CURDATE(),INTERVAL 3 DAY), 'Крепления Union Contact Pro 2015 года размер L/XL','', 'img/lot-3.jpg', 8000, '2018-7-04',12000, 2, 2),
(DATE_SUB(CURDATE(),INTERVAL 4 DAY), 'Ботинки для сноуборда DC Mutiny Charocal','', 'img/lot-4.jpg', 10999, '2018-7-04',12000, 2, 3),
(DATE_SUB(CURDATE(),INTERVAL 5 DAY), 'Куртка для сноуборда DC Mutiny Charocal','', 'img/lot-5.jpg', 7500, '2018-7-04',12000, 3, 4),
(DATE_SUB(CURDATE(),INTERVAL 6 DAY), 'Маска Oakley Canopy','', 'img/lot-6.jpg', 5400, '2018-7-04',12000, 3, 6);

/*Заполнение таблицы ставки*/

INSERT INTO rates (dt_add, summa, lot_id, user_id) values
(DATE_SUB(CURDATE(), INTERVAL Rand(50) MINUTE), 11500, 1, 1),
(DATE_SUB(CURDATE(), INTERVAL Rand(18) HOUR), 11000, 1, 2),
(DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*(50-25+1))+25 HOUR), 10500, 1, 3),
(DATE_SUB(CURDATE(), INTERVAL 7 DAY), 10000, 1, 4);

/*получить все категории;*/
select * from category;

/*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, 
ссылку на изображение, цену, количество ставок, название категории;
*/
select l.name, l.rate, l.img, c.name as 'Категория', r.kol as 'Кол.ставок', 
IFNULL(r.price, l.rate) as 'Цена'
from lots l
JOIN category c ON l.category_id=c.id
LEFT JOIN 
(Select lot_id, max(summa) price, count(*) kol
 from rates group by lot_id) r
 ON l.id= r.lot_id
 where dt_close > CURDATE()
 order by dt_add desc;
 
 /*показать лот по его id. Получите также название категории, к которой принадлежит лот*/
 Select * 
 from lots l
 JOIN category c ON l.category_id=c.id
 where l.id = 2;
 
 /*обновить название лота по его идентификатору;*/
update lots set name='йо-йо' where id = 2;

/*получить список самых свежих ставок для лота по его идентификатору;*/
select * from rates
where lot_id=1
order by dt_add desc;
