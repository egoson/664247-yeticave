<?php
require_once ("functions.php");
require_once ("init.php");

if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}

$categories =  $get_categories($link);


$is_auth = rand(0, 1);
$title_name = "404";
$user_name = 'Денис Филипкин';
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');


$page_content = include_template("404.php", [
    'equipments' => $categories
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'is_auth' => $is_auth,
    'equipments' => $categories
]);
print ($layout_content);