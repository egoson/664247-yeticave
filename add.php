<?php
require_once ("functions.php");
require_once ("init.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_lot = $_POST;
    var_dump($new_lot);
    $required = ["lot-name", "description", "start_price", "step_price", "close_sale", "category", "photo"];
    $dict = ["lot-name" => "Имя лота", "description" => "Описание", "photo" => "Изображение", "start_price" => "Начальная цена", "step_price" => "Шаг ставки", "close_sale" => "Дата окончания торгов", "category" => "Категория"];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = "Это поле надо заполнить";
        }
    }

    if (isset($_FILES["photo"]["name"])) {
        $tmp_name = $_FILES["photo"]["tmp_name"];
        $path = $_FILES["photo"]["name"];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpg") {
            $errors['file'] = 'Загрузите картинку в формате JPG';
        }
        else {
            move_uploaded_file($tmp_name, "uploads/" . $path);
            $gif["path"] = $path;
        }
    } else {
        $errors["file"] = "Вы не загрузили файл";
    }

    if (count($errors)) {
        $categories =  $get_categories($link);
        $page_content = include_template("add.php", ["image" => $image, "errors" => $errors, "dict" => $dict, "equipments" => $categories]);
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
