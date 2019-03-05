<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $min_rate = $_SESSION["user"]["min_rate"];

    if (empty($form["cost"])) {
        $error = "Заполните это поле";
    }

    if (!$error && ctype_digit($form["cost"]) && $form["cost"] >= $min_rate) {
        $cost = mysqli_real_escape_string($link, $form["cost"]);
        $rate = $add_rate($link, $form);
        $user_id = $_SESSION["user"]["id"];
        $id_rate = $get_userid_from_lot($link, $user_id);

        $user_id_updated = $update_rate_to_user($link, $id_rate["id"], $user_id);
        header("Location: lot.php?lot_id=" . $_SESSION["user"]["cur_lot_id"]);
    } else {
        $error = "Введите корректную ставку";
        $_SESSION["user"]["errors"] = $error;
        header("Location: lot.php?lot_id=" . $_SESSION["user"]["cur_lot_id"]);
    }

}








$categories = $get_categories($link);
$is_auth = rand(0, 1);
$title_name = "Лот";
$user_name = $_SESSION['user']['name'];
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