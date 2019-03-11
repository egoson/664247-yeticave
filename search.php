<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};
$lots = [];
$categories = "";
$user_name = $_SESSION['user']['name'] ?? "";
$title_name = "Поиск";
$search = $_GET["search"] ?? null;

$categories = get_categories($link);
if (isset($search)) {
    $search = trim($search);
    $search_lot = get_search_lot($link,$search);
}
$page_content = include_template("index.php", [
    'equipments' => $categories,
    'announcement' => $search_lot
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories,
    'search' => $search
]);
print ($layout_content);



