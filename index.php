<?php
require_once ("functions.php");
require_once ("init.php");

if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}

$categories =  $get_categories($link);
$lot = $get_lots($link);

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

