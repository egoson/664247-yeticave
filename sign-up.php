<?php
require_once ("functions.php");
require_once ("init.php");

session_start();
error_reporting(E_ALL);
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
};
$tpl_data = [];
$errors = null;
$form = "";
$user_name = "";
$is_auth= "";
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
        $is_set = get_email($link,$email);
        if ($is_set) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $new_user = add_user($link, $form, $password);
            if($new_user && empty($errors)) {
                header("Location: /login.php");
                exit();
            }
        }
        $tpl_data['errors'] = $errors;
        $tpl_data['values'] = $form;
    }
}

$categories =  get_categories($link);
$title_name = "Регистрация";
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
