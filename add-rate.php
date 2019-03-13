<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};
$user_name = $_SESSION['user']['name'] ?? "";
$valid_cost = ctype_digit($_GET["cost"]);
$valid_id = ctype_digit($_GET["lot_id"]);
if (isset($_GET) && isset($valid_id) && isset($valid_cost) && !empty($user_name)) {
    $form = $_GET;
    $form = array_map("trim", $form);
    $min_rate = $_SESSION["user"]["min_rate"] ?? null;
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
$layout_content = error($link, 403);
print ($layout_content);
exit();