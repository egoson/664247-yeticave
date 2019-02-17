<?php
require_once ("functions.php");

$link = mysqli_connect(localhost,root, "", yeticave);
mysqli_set_charset($link, "utf8");
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
}
else {
    $sql = "SELECT name FROM categories";
    $result = mysqli_query($link,$sql);

    if (!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    $sql = "SELECT image, l.name, start_price, c.name AS categories_name FROM lot AS l
    JOIN categories AS c ON l.categories_id = c.id ";
    $result = mysqli_query($link,$sql);

    if(!$result) {
        print("Ошибочка " . mysqli_connect_error());
    }
    else {
        $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}

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

