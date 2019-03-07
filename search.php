<?php
require_once ("functions.php");
require_once ("init.php");


if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};
$lots = [];
$categories = "";
$user_name = $_SESSION['user']['name'] ?? "";
$title_name = "Поиск";
$search = $_GET["search"] ?? "";
$categories = get_categories($link);
if ($search) {
    function get_search_lot($link,$search)
    {
        $sql = "SELECT l.id as lot_id, image, l.name, start_price, dt_close, c.name AS categories_name, MAX(r.amount) AS r_amount FROM lot AS l
          JOIN categories AS c ON l.categories_id = c.id
          LEFT JOIN rate AS r ON r.lot_id = l.id
          WHERE MATCH(l.name,l.description) AGAINST(?)
          GROUP BY l.id";
        $stmt = db_get_prepare_stmt($link, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    $search_lot = get_search_lot($link,$search);
}
$page_content = include_template("index.php", [
    'equipments' => $categories,
    'announcement' => $search_lot
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories,
    'search' => $search
]);
print ($layout_content);



