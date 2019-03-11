<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}

if (!ctype_alpha(isset($_GET["category_id"])) && !ctype_alpha(isset($_GET["cur_page"]))) {
    $category = $_GET["category_id"];
    $categories = get_categories($link);
    $lots = get_lots_by_categories($link, $category);
    $title_name = "Главная";
    $user_name = $_SESSION['user']['name'] ?? "";
} else {
    http_response_code(404);
    header("Location: 404.php");
}




if(empty($lots)) {
    http_response_code(404);
    header("Location: 404.php");
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