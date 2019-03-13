<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}
$category_id = $_GET["category_id"] ?? "";
if (!ctype_alpha($category_id) && !empty($category_id)) {
    $categories = get_categories($link);
    $lots = get_lots_by_categories($link, $category_id);
    $title_name = "Главная";
    $user_name = $_SESSION['user']['name'] ?? "";
} else {
    error_404($link);
}

if(empty($lots)) {
    error_404($link);
}

$page_content = include_template("all-lots.php", [
    'lots' => $lots
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories
]);
print ($layout_content);