<?php
require_once ("functions.php");
require_once ("init.php");
session_start();

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}
$categories =  $get_categories($link);
$lot = $get_lots($link);

$title_name = "Главная";
$user_name = "";
if (isset($_SESSION['user']['name'])) {
    $user_name = $_SESSION['user']['name'];
}

$page_content = include_template("index.php", [
    'equipments' => $categories,
    'announcement' => $lot
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories
]);
print ($layout_content);
