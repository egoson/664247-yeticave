<?php
require_once ("functions.php");
require_once ("init.php");

session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};

$error = null;
$is_error = true;
$categories = get_categories($link);
if (isset($_GET["lot_id"]) && !ctype_alpha($_GET["lot_id"])) {
    $lot_id = $_GET["lot_id"];
    $user_id = $_SESSION['user']['id'] ?? "";
    $lot = get_lot($link, $_GET["lot_id"]);
    $raties = get_raties($link, $lot["lot_id"]);
    $max_rate = get_max_rate($link, $lot["lot_id"]);
    $is_users_lot = $lot["users_id"] === $user_id ? true : false ;
    $checked_rate = is_check_rate($link,$lot_id,$user_id);
    $min_rate = !$lot["r_amount"] ? $lot["start_price"] + $lot["step_price"] : $lot["step_price"] + $max_rate["max_amount"];
    $_SESSION["user"]["min_rate"] = $min_rate;
    $error = $_SESSION['user']['errors'] ?? null;
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
            "max_rate" => $max_rate,
            "error" => $error
        ]);
    }
}
if ($is_error) {
    $page_content = include_template('404.php', [
        "equipments" => $categories]);
};
$title_name = "Лот";
$user_name = "";
if (isset($_SESSION['user']['name'])) {
    $user_name = $_SESSION['user']['name'];
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "user" => $user_name,
    "title" => $title_name,
    "equipments" => $categories
]);
print ($layout_content);

