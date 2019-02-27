<?php
require_once ("functions.php");
require_once ("init.php");
var_dump($_POST);
$categories =  $get_categories($link);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_lot = $_POST;
    $required = ["lot-name", "description", "start_price", "step_price", "close_sale", "category", "photo", "lot-date"];
    $dict = ["lot-name" => "Имя лота", "description" => "Описание", "photo" => "Изображение", "start_price" => "Начальная цена", "step_price" => "Шаг ставки", "lot-date" => "Дата окончания торгов", "category" => "Категория"];
    $errors = [];


    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = "Это поле надо заполнить";
        }
    }





    if (isset($new_lot["step_price"]) && $new_lot["step_price"] > 0) {
        $step_price = $new_lot["step_price"];
    } else {
        $errors["step_price"] = "введите корректное число";
    }

    if (isset($new_lot["start_price"])) {
        $start_price = $new_lot["start_price"];
    }

    if (isset($new_lot["description"])) {
        $description = $new_lot["description"];
    }

    if (isset($new_lot["lot-name"])) {
        $lot_name = $new_lot["lot-name"];
    }

    if (isset($new_lot["category"]) && $new_lot["category"] == $get_category($link, $new_lot["category"])) {
        $category = $new_lot["category"];
    } else {
        $errors["categories"] = "Нужно выбрать категорию";
    }

    $new_lot["lot-date"] = date("d.m.Y", strtotime($new_lot["lot-date"]));
    if (isset($new_lot["lot-date"]) && check_date_format($new_lot["lot-date"]) && strtotime($new_lot["lot-date"]) > strtotime("now")) {
        $lot_date = date('Y-m-d',strtotime($new_lot["lot-date"]));
    } else {
        $errors["lot-date"] = "Введите корректную дату торгов";
    }
    if (isset($_FILES["photo"])) {
        $new_lot_add = $_FILES["photo"]["name"];
        $filename = uniqid() . ".jpg";
        $new_lot_add["path"] = $filename;
        move_uploaded_file($_FILES["photo"]["tmp_name"], "img/" . $filename);
        var_dump($_FILES["photo"]);
        $sql = 'INSERT INTO lot (lot.name, description, image, start_price, categories_id, step_price, users_id, win_id) VALUES (?, ?, ?, ?, ?, 1, 1, 1)';
        $stmt = db_get_prepare_stmt($link, $sql, [$new_lot["lot-name"],$new_lot_add["description"],$new_lot_add["path"],$new_lot_add["start_price"], $new_lot_add["step_price"]]);
        $res = mysqli_stmt_execute($stmt);
        var_dump($new_lot_add["lot-name"]);
        if ($res) {
            $new_lot_add = mysqli_insert_id($link);

            header("Location: lot.php?id=" . $new_lot_add);
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
    }
var_dump($new_lot["lot-name"]);

    if (count($errors)) {
        $page_content = include_template("add.php", ["image" => $image,
            "errors" => $errors,
            "dict" => $dict,
            "equipments" => $categories,
            "step_price_cur" => $step_price,
            "start_price_cur" => $start_price,
            "description_cur" => $description,
            "lot_name_cur" => $lot_name,
            "category_cur" => $category,
            "lot_date_cur" => $lot_date
        ]);
    }
    else {
        //сформировать запрос на страницу с добавленным лотом
        $page_content = include_template("lot.php", ["image" => $image]);
    }
}



else {
    $categories =  $get_categories($link);
    $page_content = include_template('add.php', ["equipments" => $categories]);
}

if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};


$is_auth = rand(0, 1);
$title_name = "Добавить лот";
$user_name = "Денис Филипкин";
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
