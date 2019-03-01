<?php
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

function min_rate($price,$step_price) {
    return do_price($price + $step_price);
};

function do_time_to_cell()
{
    $ts = time();
    $ts_midnight = strtotime('tomorrow');
    $time_to_midnight = $ts_midnight - $ts;
    $hours = floor($time_to_midnight / 3600);
    $minutes = floor(($time_to_midnight % 3600) / 60);
    return $hours . ":" . sprintf('%02d', $minutes);
};



function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    return $result;
}
$get_categories = function ($link) {

    $sql = "SELECT name FROM categories";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $categories;
};

$get_lots = function ($link) {

    $sql = "SELECT l.id as lot_id, image, l.name, start_price, c.name AS categories_name, MAX(r.amount) AS r_amount FROM lot AS l
    JOIN categories AS c ON l.categories_id = c.id
    JOIN rate AS r ON r.lot_id = l.id
    GROUP BY l.id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    } else {
        $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
    return $lot;
};

$get_lot = function ($link, $lot_id) {

    $sql = "SELECT l.id as lot_id, image, l.name, l.description, start_price, c.name AS categories_name, MAX(r.amount) AS r_amount, l.step_price FROM lot AS l
    JOIN categories AS c ON l.categories_id = c.id
    JOIN rate AS r ON r.lot_id = l.id
    WHERE lot_id = $lot_id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    } else {
        $cur_lot = mysqli_fetch_array($result, MYSQLI_ASSOC);
    };
    return $cur_lot;
};

$get_raties = function ($link, $lot_id) {
    $sql = "SELECT r.id as rate_id, l.id AS lot_id, r.users_id as rate_user, u.name, r.dt_add, r.amount FROM rate AS r
    JOIN users AS u ON u.id = r.users_id
    JOIN lot AS l ON l.id = r.lot_id
    WHERE l.id = $lot_id
    ORDER BY r.amount DESC ";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    } else {
        $cur_raties = mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
    return $cur_raties;
};

$get_id_category = function ($link, $name_category) {
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

$get_category = function ($link, $name_category) {

    $sql = "SELECT name FROM categories WHERE name = '$name_category'";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $categories = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    return $categories["name"];
};

$add_photo = function ($link, $photo) {
    $sql = "INSERT INTO lot (image) VALUES ($photo)";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $add_phot = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    return $add_phot;
};

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

$get_email = function ($link,$email) {
    $sql = "SELECT email FROM users WHERE email = '$email'";

    $result = mysqli_query($link, $sql);
    $is_set = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $is_set;
};

$add_rate = function ($link, $lot_id) {
    $sql = 'INSERT INTO lot (amount, users_id, lot_id) VALUES (?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$new_lot_add["cost"], $new_lot_add["description"], $new_lot_add["path"],$new_lot_add["start_price"], $new_lot_add["step_price"], $id_category, $new_lot_add["lot-date"]]);
    $res = mysqli_stmt_execute($stmt);
    return $res;
};