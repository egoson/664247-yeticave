<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}

if (!ctype_alpha(isset($_GET["category_id"]))) {
    $category = $_GET["category_id"];
};
$lots = get_lots_by_categories($link, $category);
if(empty($lots)) {
    header("Location: 404.php");
}
$categories = get_categories($link);
$lot = get_lots($link);
$title_name = "Главная";
$user_name = $_SESSION['user']['name'] ?? "";

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