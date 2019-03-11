<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};
$user_name = $_SESSION['user']['name'] ?? header("Location: 403.php");

$categories =  get_categories($link);
$is_auth = "";
$step_price = "";
$start_price = "";
$category = null;
$file = "";
$lot_date = "";
$lot_name = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_lot = $_POST;
    var_dump($new_lot);
    array_walk($new_lot, 'trim_value');
    $required = ["lot-name", "description", "start_price", "step_price", "lot-date", "category", "lot-date"];
    $dict = ["lot-name" => "Имя лота", "description" => "Описание", "photo" => "Изображение", "start_price" => "Начальная цена", "step_price" => "Шаг ставки", "lot-date" => "Дата окончания торгов", "category" => "Категория"];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = "Это поле надо заполнить";
        }
    }
    if (!empty($_FILES["photo"]["name"])) {
        $file = $_FILES["photo"];
        $tmp_name = $_FILES['photo']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = mime_content_type($tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors["photo"] = 'Загрузите картинку формата JPG';
        } else {
            $filename = uniqid() . ".jpg";
            $new_lot["path"] = $filename;
            move_uploaded_file($_FILES["photo"]["tmp_name"], 'img/' . $filename);
            $id_category = get_id_category($link, $new_lot["category"]);
            $new_lot["path"] = "img/" . $new_lot["path"];
            if (isset($_SESSION["user"]["id"])) {
                $user_id = $_SESSION["user"]["id"];
            }
        }
    } else {
        $errors["photo"] = 'Загрузите картинку';
    }
    if (isset($new_lot["step_price"]) && $new_lot["step_price"] > 0 && ctype_digit($new_lot["step_price"])) {
        $step_price = $new_lot["step_price"];
    } else {
        $errors["step_price"] = "введите корректное число";
    }
    if (isset($new_lot["start_price"]) && $new_lot["start_price"] > 0 && ctype_digit($new_lot["start_price"])) {
        $start_price = $new_lot["start_price"];
    } else {
        $errors["start_price"] = "введите корректное число";
    }
    if (isset($new_lot["description"])) {
        $description = $new_lot["description"];
    }
    if (isset($new_lot["lot-name"]) && iconv_strlen($new_lot["lot-name"]) < 128 ) {
        $lot_name = $new_lot["lot-name"];
    } else {
        $errors["lot-name"] = "Превышено допустимое количество знаков в поле 'Имя'";
    }
    $category = get_category($link, $new_lot["category"]);
    if (isset($new_lot["category"]) && $new_lot["category"] === $category["name"]) {
        $category = $new_lot["category"];
    } else {
        $errors["categories"] = "Нужно выбрать категорию";
    }
    $checked_date = date("d.m.Y", strtotime($new_lot["lot-date"]));
    if (empty($new_lot["lot-date"]) || check_date_format($checked_date) && strtotime($new_lot["lot-date"]) < strtotime("now")) {
        $errors["lot-date"] = "Введите корректную дату торгов";
    }
    $lot_date = $new_lot["lot-date"];

    if (count($errors)) {
        $page_content = include_template("add.php", [
            "errors" => $errors,
            "dict" => $dict,
            "equipments" => $categories,
            "step_price_cur" => $step_price,
            "start_price_cur" => $start_price,
            "description_cur" => $description,
            "lot_name_cur" => $lot_name,
            "category_cur" => $category,
            "lot_date_cur" => $lot_date,
            "photo" => $file
        ]);
    }
    else {

        $add = add_lot($link, $new_lot, $id_category, $user_id);
        $lot_id = get_id_lot($link, $user_id);
        header("Location: lot.php?lot_id=" . $lot_id["id"]);
        exit();
    }
}
else {
    $categories =  get_categories($link);
    $page_content = include_template('add.php', ["equipments" => $categories]);
}

$user_name = "";
$title_name = "Добавить лот";
if (isset($_SESSION['user']['name'])) {
    $user_name = $_SESSION['user']['name'];
};
$content = include_template('error.php', ['error' => mysqli_error($link)]);
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "user" => $user_name,
    "title" => $title_name,
    "is_auth" => $is_auth,
    "equipments" => $categories
]);
print ($layout_content);

