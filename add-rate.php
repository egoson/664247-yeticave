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
        $rate = $add_rate($link, $form);
        $user_id = $_SESSION["user"]["id"];

        $id_rate = $get_userid_from_lot($link, $user_id);
        unset($_SESSION["user"]["errors"]);
        $cur_lot = $_SESSION["user"]["cur_lot_id"];
        $users_lot = $get_users_lot($link, $user_id);
        $is_users_lot = $users_lot["lot_id"] === $cur_lot ? true : false ;
        $dt_close = $_SESSION["user"]["dt_close"];
        $user_dt_add = ($_SESSION["user"]["dt_add"]);
        $checked_rate = $get_check_rate($link, $users_lot["lot_id"], $user_id);
        $user_id_updated = $update_rate_to_user($link, $id_rate["id"], $user_id);


        // вот тут-то я и застрял

        //var_dump($user_id && strtotime($dt_close) > time(NOW) && !$is_users_lot && !$checked_rate);
        if(!$user_id && strtotime($dt_close) > time(NOW) && $is_users_lot && $checked_rate) {
            echo ("sdadadsadsadsada");

        }
            unset($_SESSION["user"]["errors"]);
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