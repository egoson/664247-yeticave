INSERT INTO categories (name) VALUES ("Доски и лыжи"), ("Крепления"), ("Ботинки"), ("Одежда"), ("Инструменты"), ("Разное"); -- добавляет категории в таблицу категорий

INSERT INTO users (email,users.password, name, contacts, avatar) VALUES -- добавляет пользователей в таблицу пользователей
  (
    "egoson@mail.ru",
    "sda112",
    "Den",
    "89041989999",
    "hhjsj.ss"
  ),
  (
    "myson@mail.ru",
    "sda112",
    "Daha",
    "89021989999",
    "hhjsj.sss"
  ),
  (
    "oson@mail.ru",
    "sda112",
    "Vanyz",
    "890419999",
    "hhjssj.ss"
  ),
  (
    "on@mail.ru",
    "sda112",
    "Datt",
    "89021289999",
    "hhj11sj.sss"
  );

INSERT INTO lot (name, description, image, start_price, dt_close, step_price, users_id, win_id, categories_id) VALUES -- добавляет лот в таблицу лотов
  (
    "2014 Rossignol District Snowboard",
    "Легкий маневренный сноуборд, готовый дать жару в любом парке,
    растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
    снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер
    позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите
    на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.",
    "img/lot-1.jpg",
    "10999",
    "2019-03-22 12:40:00",
    "1001",
    "1",
    NULL,
    "1"
  ),
  (
    "DC Ply Mens 2016/2017 Snowboard",
    "Тоже самое тут в описании",
    "img/lot-2.jpg",
    "9800",
    "2019-03-20 12:40:00",
    "1001",
    "2",
    NULL,
    "1"
  ),
  (
    "Крепления Union Contact Pro 2015 года размер L/XL",
    "Тоже самое тут в описании",
    "img/lot-3.jpg",
    "8000",
    "2019-05-22 12:40:00",
    "1001",
    "3",
    "1",
    "2"
  ),
  (
    "Ботинки для сноуборда DC Mutiny Charocal",
    "Тоже самое тут в описании",
    "img/lot-4.jpg",
    "10999",
    "2019-03-21 12:40:00",
    "1001",
    "4",
    "2",
    "3"
  ),
  (
    "Куртка для сноуборда DC Mutiny Charocal",
    "Тоже самое тут в описании",
    "img/lot-5.jpg",
    "7500",
    "2019-03-22 12:40:00",
    "1001",
    "4",
    "3",
    "4"
  ),
  (
    "Маска Oakley Canopy",
    "Тоже самое тут в описании",
    "img/lot-6.jpg",
    "5400",
    "2019-02-22 12:40:00",
    "1001",
    "1",
    "2",
    "6"
  );

INSERT INTO rate (amount, users_id, lot_id) VALUES -- добавляет ставку в таблицу ставок
  (
    "15000",
    "1",
    "2"
  ),
  (
    "15000",
    "1",
    "3"
  ),
  (
    "12000",
    "2",
    "3"
  ),
  (
    "18000",
    "3",
    "3"
  ),
  (
    "17000",
    "3",
    "2"
  ),
  (
    "13500",
    "4",
    "2"
  );

SELECT * FROM categories; -- выводит все строки из таблицы категорий

SELECT l.name, l.start_price, l.image, r.amount, c.name FROM lot AS l -- выводит новые, открытые лоты
LEFT JOIN rate AS r ON r.users_id = l.users_id
JOIN categories AS c ON c.id = l.categories_id
WHERE l.dt_close > l.dt_add
ORDER BY l.dt_add DESC;

SELECT image, l.name, start_price, c.name AS categories_name FROM lot AS l -- выводит лот по id
JOIN categories AS c ON l.categories_id = c.id
WHERE l.id = 1;

UPDATE lot AS l SET name = "Самая крутая доска на свете" -- обновляет данные в таблице лотов в столбце name
WHERE l.id = 1;

SELECT * FROM rate AS r -- выводит новые ставки по id
WHERE r.lot_id = 1
ORDER BY r.dt_add DESC;