<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};
$user_name = $_SESSION['user']['name'] ?? "";
$min_rate = null;
if (isset($_SESSION['user']['name'])) {
    if (isset($_GET) && !ctype_alpha(isset($_GET["lot_id"])) && !ctype_alpha(isset($_GET["cost"]))) {
        $form = $_GET;
        array_walk($form, 'trim_value');
        $min_rate = isset($_SESSION["user"]["min_rate"]);
        if (empty($form["cost"])) {
            $error = "Заполните это поле";
        }
        $error = "";
        if (!$error && ctype_digit($form["cost"]) && $form["cost"] >= $min_rate) {
            $rate = add_rate($link, $form);
        } else {
            $error = "Введите корректную ставку";
            $_SESSION["user"]["errors"] = $error;
        }
        header("Location: lot.php?lot_id=" . $form["lot_id"]);
        exit();
    }
}
header("Location: 403.php");
exit();