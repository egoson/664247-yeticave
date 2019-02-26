<?php
require_once ("functions.php");
require_once ("init.php");

if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};

$is_error = true;

if ($_GET["lot_id"]) {
    $lot = $get_lot($link, $_GET["lot_id"]);
    $categories = $get_categories($link);
    $raties = $get_raties($link, $_GET["lot_id"]);

    if ($_GET["lot_id"] === $lot["lot_id"]) {
        $is_error = false;
        $page_content = include_template("lot.php", [
            "equipments" => $categories,
            "lot" => $lot,
            "raties" => $raties
        ]);
    } 
}
if ($is_error) {
    $page_content = include_template('404.php', [
        "equipments" => $categories]);
};

$is_auth = rand(0, 1);
$title_name = "Лот";
$user_name = "Денис Филипкин";
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');


$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "user" => $user_name,
    "title" => $title_name,
    "is_auth" => $is_auth,
    "equipments" => $categories
]);
print ($layout_content);
