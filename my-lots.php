<?php
require_once ("functions.php");
require_once ("init.php");


session_start();
$user_name = $_SESSION['user']['name'] ?? header("Location: 404.php");

$user_id = $_SESSION["user"]["id"];
$categories =  get_categories($link);
var_dump($user_id);
function get_my_rates($link,$user_id) {
    $sql = "SELECT  r.lot_id, r.amount, r.users_id, l.name, l.image, l.dt_close,  c.name AS categories_name  FROM rate AS r 
JOIN lot AS l ON r.lot_id = l.id
JOIN categories AS c ON l.categories_id = c.id
WHERE r.users_id = '5'";
    var_dump($sql);
    $stmt = db_get_prepare_stmt($link, $sql, [$user_id]);
    var_dump($stmt);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    var_dump($result);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$my_raties = get_my_rates($link,$user_id);
var_dump($my_raties);