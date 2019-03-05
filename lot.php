<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};

$is_error = true;
$categories = $get_categories($link);
if ($_GET["lot_id"] && !ctype_alpha($_GET["lot_id"])) {
    $lot_id = $_GET["lot_id"];
    $user_id = $_SESSION["user"]["id"];
    $lot = $get_lot($link, $_GET["lot_id"]);
    $raties = $get_raties($link, $lot["lot_id"]);
    $max_rate = $get_max_rate($link, $lot["lot_id"]);

    $_SESSION["user"]["cur_lot_id"] = $lot_id;
    $_SESSION["user"]["dt_add"] = $lot["dt_add"];
    $_SESSION["user"]["url"] = "lot.php?lot_id=" . $lot["lot_id"];

    $_SESSION["user"]["start_price"] = $lot["start_price"];

    $is_lot_user = $_SESSION["user"]["lot_id"] == $_SESSION["user"]["cur_lot_id"] ? true : false ;

    $dt_close = $lot["dt_close"];
    $_SESSION["user"]["dt_close"] = $dt_close;

    $users_lot = $get_users_lot($link, $user_id);
    $is_users_lot = $users_lot["lot_id"] === $_SESSION["user"]["cur_lot_id"] ? true : false ;

    $checked_rate = $is_check_rate($link,$lot_id,$user_id);
    $min_rate = !$lot["r_amount"] ? $lot["start_price"] + $lot["step_price"] : $lot["step_price"] + $max_rate["max_amount"];
    $_SESSION["user"]["min_rate"] = $min_rate;
    $error = $_SESSION["user"]["errors"];

    if ($_GET["lot_id"] === $lot["lot_id"]) {
        $is_error = false;
        unset($_SESSION["user"]["errors"]);
        $page_content = include_template("lot.php", [
            "equipments" => $categories,
            "lot" => $lot,
            "raties" => $raties,
            "checked_rate" => $checked_rate,
            "min_rate" => $min_rate,
            "is_users_lot" => $is_users_lot,
            "error" => $error
        ]);

    }
}
if ($is_error) {
    $page_content = include_template('404.php', [
        "equipments" => $categories]);
};

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

