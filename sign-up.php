<?php
require_once ("functions.php");
require_once ("init.php");
session_start();


$tpl_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $errors = [];

    $req_fields = ["email", "password", "name", "contacts"];

    foreach ($req_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Не заполнено поле " . $field;
        }
    }

    if (!filter_var($form["email"], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Неверно введен email адрес";
    }


    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $form['email']);
        $is_set = $get_email($link,$email);
        if ($is_set) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);



                $sql = 'INSERT INTO users (email, users.password, users.name, contacts) VALUES (?, ?, ?, ?)';
                $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $password, $form['name'], $form['contacts']]);
                $res = mysqli_stmt_execute($stmt);


            if($res && empty($errors)) {
                header("Location: /login.php");
                exit();
            }
        }
        $tpl_data['errors'] = $errors;
        $tpl_data['values'] = $form;
    }

}


if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}




$categories =  $get_categories($link);

$is_auth = rand(0, 1);
$title_name = "Регистрация";
$user_name = 'Денис Филипкин';
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');


$page_content = include_template("sign-up.php", [
    'equipments' => $categories,
    "errors" => $errors,
    "values" => $form
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'is_auth' => $is_auth,
    'equipments' => $categories
]);
print ($layout_content);