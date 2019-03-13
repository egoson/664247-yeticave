<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}
http_response_code(403);
$categories =  get_categories($link);
$title_name = "403";
$user_name = $_SESSION['user']['name'] ?? "";
$page_content = include_template("403.php", [
    'equipments' => $categories
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories
]);
print ($layout_content);