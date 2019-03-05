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
    $error = "";
    if (!$error && ctype_digit($form["cost"]) && $form["cost"] >= $min_rate) {
        $rate = add_rate($link, $form);
        header("Location: lot.php?lot_id=" . $_SESSION["user"]["cur_lot_id"]);
    } else {
        $error = "Введите корректную ставку";
        $_SESSION["user"]["errors"] = $error;
        header("Location: lot.php?lot_id=" . $_SESSION["user"]["cur_lot_id"]);
    }
}