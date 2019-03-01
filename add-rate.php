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
    if (empty($form["cost"])) {
        $error = "Заполните это поле";
    }

    if (!$error && ctype_digit($form["cost"]) ) {
        $cost = mysqli_real_escape_string($link, $form["cost"]);
        $sql = "INSERT INTO rate (amount, users_id, lot_id) VALUES (?,?,?)";
        $stmt = db_get_prepare_stmt($link, $sql, [$form["cost"], $_SESSION["user"]["id"], $_SESSION["user"]["lot_id"]]);
        $res = mysqli_stmt_execute($stmt);
        unset($_SESSION["user"]["errors"]);

       header("Location: lot.php?lot_id=" . $_SESSION["user"]["lot_id"]);

    } else {
        $error = "Введите корректную ставку";
        $_SESSION["user"]["errors"] = $error;
        header("Location: lot.php?lot_id=" . $_SESSION["user"]["lot_id"]);
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