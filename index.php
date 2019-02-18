<?php
require_once ("functions.php");
require_once ("init.php");

if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}

$select_categories = function ($link) {
    $sql = "SELECT name FROM categories";
    $result = mysqli_query($link,$sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $categories;
};

$select_lot = function ($link) {

    $sql = "SELECT image, l.name, start_price, c.name AS categories_name, r.amount FROM lot AS l
    JOIN categories AS c ON l.categories_id = c.id
    JOIN rate AS r ON r.lot_id = l.id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    } else {
        $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
    return $lot;
};

$categories =  $select_categories($link);
$lot = $select_lot($link);

$is_auth = rand(0, 1);
$title_name = "Главная";
$user_name = 'Денис Филипкин';
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');


$page_content = include_template("index.php", [
    'equipments' => $categories,
    'announcement' => $lot
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'is_auth' => $is_auth,
    'equipments' => $categories
]);
print ($layout_content);

