INSERT INTO categories (name) VALUES ("Доски и лыжи"), ("Крепления"), ("Ботинки"), ("Одежда"), ("Инструменты"), ("Разное"); -- добавляет категории в таблицу категорий

INSERT INTO users (email, name, contacts, avatar, lot_id, rate_id) VALUES -- добавляет пользователей в таблицу пользователей
  (
    "egoson@mail.ru",
    "Den",
    "89041989999",
    "hhjsj.ss",
    "1",
    "1"
  ),
  (
    "myson@mail.ru",
    "Daha",
    "89021989999",
    "hhjsj.sss",
    "2",
    "2"
  );

INSERT INTO lot (name, description, image, start_price, step_price, users_id, win_id, categories_id) VALUES -- добавляет лот в таблицу лотов
  (
    "2014 Rossignol District Snowboard",
    "Легкий маневренный сноуборд, готовый дать жару в любом парке,
    растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
    снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер
    позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите
    на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.",
    "board1-lot.ru",
    "10999",
    "1001",
    "1",
    "1",
    "1"
  ),
  (
    "DC Ply Mens 2016/2017 Snowboard",
    "Тоже самое тут в описании",
    "board2-lot.ru",
    "159999",
    "1001",
    "2",
    "2",
    "1"
  ),
  (
    "Крепления Union Contact Pro 2015 года размер L/XL",
    "Тоже самое тут в описании",
    "board3-lot.ru",
    "8000",
    "1001",
    "3",
    "0",
    "2"
  ),
  (
    "Ботинки для сноуборда DC Mutiny Charocal",
    "Тоже самое тут в описании",
    "board4-lot.ru",
    "10999",
    "1001",
    "4",
    "0",
    "3"
  ),
  (
    "Куртка для сноуборда DC Mutiny Charocal",
    "Тоже самое тут в описании",
    "board5-lot.ru",
    "7500",
    "1001",
    "5",
    "0",
    "4"
  ),
  (
    "Маска Oakley Canopy",
    "Тоже самое тут в описании",
    "board6-lot.ru",
    "5400",
    "1001",
    "6",
    "0",
    "6"
  );

INSERT INTO rate (amount, users_id, lot_id) VALUES -- добавляет ставку в таблицу ставок
  (
    "15000",
    "1",
    "1"
  ),
  (
    "12000",
    "2",
    "2"
  ),
  (
    "40000",
    "3",
    "1"
  ),
  (
    "13500",
    "4",
    "3"
  );

SELECT * FROM categories; -- выводит все строки из таблицы категорий

SELECT l.name, l.start_price, l.image, r.amount, c.name FROM lot AS l -- выводит новые, открытые лоты
LEFT JOIN rate AS r ON r.users_id = l.users_id
JOIN categories AS c ON c.id = l.categories_id
WHERE l.dt_close > l.dt_add
ORDER BY l.dt_add DESC

SELECT * FROM lot AS l -- выводит лот по id
JOIN categories AS c ON l.categories_id = c.id
WHERE l.id = 1;

UPDATE lot AS l SET name = "Самая крутая доска на свете" -- обновляет данные в таблице лотов в столбце name
WHERE l.id = 1;

SELECT * FROM rate AS r -- выводит новые ставки по id
WHERE r.lot_id = 1
ORDER BY r.dt_add DESC;