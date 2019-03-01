<?php
require_once ("functions.php");
require_once ("init.php");
session_start();

if(!$_SESSION) {
    header("Location: 404.php");
}

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

    if (isset($new_lot["step_price"]) && $new_lot["step_price"] > 0 && ctype_digit($new_lot["step_price"])) {
        $step_price = $new_lot["step_price"];
    } else {
        $errors["step_price"] = "введите корректное число";
    }

    if (isset($new_lot["start_price"]) && ctype_digit($new_lot["start_price"])) {
        $start_price = $new_lot["start_price"];
    } else {
        $errors["start_price"] = "введите корректное число";
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
        $new_lot_add = $_POST;
        $tmp_name = $_FILES['photo']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "jpg") {
            $errors["file"] = 'Загрузите картинку формата JPG';
        }


        $filename = uniqid() . ".jpg";
        $new_lot_add["path"] = $filename;
        move_uploaded_file($_FILES["photo"]["tmp_name"], 'img/' . $filename);
        $id_category = $get_id_category($link,$new_lot_add["category"]);
        $new_lot_add["path"] = "img/" . $new_lot_add["path"];
        $user_id = $_SESSION["user"]["id"];
        unset($_SESSION["user"]["errors"]);
        $add = $add_lot($link, $new_lot_add, $id_category, $user_id);
        if ($add) {
            $new_lot_add = mysqli_insert_id($link);
            header("Location: lot.php?lot_id=" . $new_lot_add);
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
        }

    }


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
            "lot_date_cur" => $lot_date,
            "file_err" => $file
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

    $title_name = "Добавить лот";
    $user_name = $_SESSION['user']['name'];
    date_default_timezone_set("Europe/Moscow");
    setlocale(LC_ALL, 'ru_RU');


    $content = include_template('error.php', ['error' => mysqli_error($link)]);

    $layout_content = include_template("layout.php", [
        "content" => $page_content,
        "user" => $user_name,
        "title" => $title_name,
        "is_auth" => $is_auth,
        "equipments" => $categories
    ]);
    print ($layout_content);

