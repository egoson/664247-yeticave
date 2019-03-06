<?php
/**
 * Функция вставки шаблона с данными
 * @param string $name
 * @param array $data
 * @return false|string/
 */
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = 'Error. Please restart';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require_once $name;
    $result = ob_get_clean();
    return $result;
};

/**
 * Функция для форматирования цены.
 *
 * Ставит пробел после каждого третьего знака.
 *
 * @param integer $price
 * @param bool $rub
 * @return float|string
 */
function do_price($price, $rub = true)
{
    $integer_price = ceil($price);
    $integer_price = number_format($integer_price, 0, ',', ' ');
    if ($rub) {
        $rub = "<b class=\"rub\">р</b>";
        $integer_price = $integer_price . $rub;
    }
    return $integer_price;
};

/**
 * Функия для показа верного написания слова
 * Считает время с момента установки значение, если прошло больше 60 сек, устанавливает "минут" и тд.
 *
 * @param array $raties
 * @return string
 */
function do_time_rate($raties) {
    $difference_time = time() - strtotime($raties) + 3600;
    if ($difference_time < 60) {
        $time_rate = "только что";
    }  elseif ($difference_time >= 60 && $difference_time < 3600) {
        $time_rate = round($difference_time / 60) . " минут";
    } elseif ($difference_time >= 3600 && $difference_time < 86400) {
        $time_rate = round($difference_time / 3600) . " часов";
    } elseif ($difference_time > 86400) {
        $time_rate = round($difference_time / 86400) . " дней";
    }
    return $time_rate;
};

/**
 * Функция возвращает сумму двух переменных
 * @param integer $price
 * @param integer $step_price
 * @return mixed
 */
function min_rate($price,$step_price) {
    return $price + $step_price;
};

/**
 * Функция считает сколько осталось времени до полуночи
 * @return string
 */
function do_time_to_cell()
{
    $ts = time();
    $ts_midnight = strtotime('tomorrow');
    $time_to_midnight = $ts_midnight - $ts;
    $hours = floor($time_to_midnight / 3600);
    $minutes = floor(($time_to_midnight % 3600) / 60);
    return $hours . ":" . sprintf('%02d', $minutes);
};


/**
 * Функция изменяет формат даты
 * @param string $date
 * @return bool
 */
function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    return $result;
}

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_categories($link) {

    $sql = "SELECT name FROM categories";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_lots($link) {

    $sql = "SELECT l.id as lot_id, image, l.name, start_price, c.name AS categories_name, MAX(r.amount) AS r_amount FROM lot AS l
    JOIN categories AS c ON l.categories_id = c.id
    LEFT JOIN rate AS r ON r.lot_id = l.id
    WHERE dt_close > NOW()
    GROUP BY l.id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_lot($link, $lot_id) {

    $sql = "SELECT l.id as lot_id, l.dt_add, image, dt_close, l.name, l.description, start_price, c.name AS categories_name, MAX(r.amount) AS r_amount, l.step_price, l.users_id FROM lot AS l
    JOIN categories AS c ON l.categories_id = c.id
    JOIN rate AS r ON r.lot_id = l.id
    WHERE lot_id = $lot_id AND  dt_close > NOW() ";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_raties($link, $lot_id) {
    $sql = "SELECT r.id as rate_id, l.id AS lot_id, r.users_id as rate_user, u.name, r.dt_add, r.amount FROM rate AS r
    JOIN users AS u ON u.id = r.users_id
    JOIN lot AS l ON l.id = r.lot_id
    WHERE l.id = $lot_id
    ORDER BY r.amount DESC ";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_max_rate($link, $lot_id) {
    $sql = "SELECT MAX(r.amount) AS max_amount FROM rate AS r
  
    JOIN lot AS l ON l.id = r.lot_id
    WHERE l.id = $lot_id ";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_id_category($link, $name_category) {
    $sql = "SELECT id FROM categories WHERE name = '$name_category'";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $categories = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    return $categories["id"];
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_category($link, $name_category) {

    $sql = "SELECT name FROM categories WHERE name = '$name_category'";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return $categories = mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция добавляет данные в БД
 * @param $link
 * @return array|null
 */
function add_photo($link, $photo) {
    $sql = "INSERT INTO lot (image) VALUES ($photo)";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};


/**
 * Функция помощник для подготовленных выражений... я потреял описание, возможно написал чушь)
 * @param $link
 * @param $sql
 * @param array $data
 * @return bool|mysqli_stmt
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_email($link,$email) {
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция добавляет данные в БД
 * @param $link
 * @return array|null
 */
function add_lot($link, $new_lot, $id_category, $user_id) {
    $sql = 'INSERT INTO lot ( lot.name, lot.description, image, start_price, step_price, categories_id, dt_close,  users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$new_lot["lot-name"], $new_lot["description"], $new_lot["path"],$new_lot["start_price"], $new_lot["step_price"], $id_category, $new_lot["lot-date"], $user_id]);
    return mysqli_stmt_execute($stmt);
};

/**
 * Функция добавляет данные в БД
 * @param $link
 * @return array|null
 */
function add_rate($link, $form) {
    $sql = "INSERT INTO rate (amount, users_id, lot_id) VALUES (?,?,?)";
    $stmt = db_get_prepare_stmt($link, $sql, [$form["cost"], $_SESSION["user"]["id"], $_SESSION["user"]["cur_lot_id"]]);
    return mysqli_stmt_execute($stmt);
};



/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_id_user($link, $user_id) {
    $sql = "SELECT id FROM users WHERE email = '$user_id'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция обновляет данные в БД
 * @param $link
 * @return array|null
 */
function update_lot_to_user($link, $id_lot, $id_user) {
    $sql = "UPDATE users SET lot_id=(?) WHERE id = (?)";
    $stmt = db_get_prepare_stmt($link, $sql, [$id_lot, $id_user]);
    return mysqli_stmt_execute($stmt);
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_id_lot($link,$user_id) {
    $sql = "SELECT MAX(id) AS id FROM lot WHERE  users_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_check_rate($link, $lot_id, $user_id) {
    $sql = "SELECT users_id, lot_id FROM rate AS r WHERE r.lot_id = '$lot_id' AND r.users_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция возвращает данные из БД
 * @param $link
 * @return array|null
 */
function get_userid_from_lot($link, $user_id ) {
    $sql = "SELECT id FROM rate WHERE  users_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
};

/**
 * Функция проверяет на наличие данных в БД
 * @param $link
 * @return array|null
 */
function is_check_rate($link,$lot_id,$user_id) {
    $sql = "SELECT lot_id, users_id FROM rate WHERE lot_id ='$lot_id' AND users_id='$user_id'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
};

/**
 * Функия получает пользователя по переданному email
 * @param $link
 * @param $email
 * @return array|null
 */
function get_user($link, $email)
{
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;
    return $user;
}

/**
 * Функия добавляет пользователя в БД
 * @param $link
 * @param $form
 * @param $password
 * @return bool
 */
function add_user($link, $form, $password)
{
    $sql = 'INSERT INTO users (email, users.password, users.name, contacts) VALUES (?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $password, $form['name'], $form['contacts']]);
    return mysqli_stmt_execute($stmt);
}