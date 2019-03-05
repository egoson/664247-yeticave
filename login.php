<?php
require_once ("functions.php");
require_once ("init.php");

session_start();
$link_to_cur_page = $_SESSION["user"]["url"];
$lot = $get_lots($link);
$categories =  $get_categories($link);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if(empty($form[$field])) {
            $errors[$field] = "Это поле надо заполнить";
        }
    }

    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;

    if(!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = $errors['email'] ??  "Данный email не существует";
    }
    if (count($errors)) {
        $page_content = include_template('login.php', ['form' => $form, 'errors' => $errors, 'email' => $email, 'equipments' => $categories]);
    }
    else {
        header("Location: /" . $link_to_cur_page);
        exit();
    }
} else {
    if (isset($_SESSION['user']["name"])) {
        $page_content = include_template('index.php', ['equipments' => $categories, 'announcement' => $lot]);
    }
    else {

        $page_content = include_template("login.php", [
            'equipments' => $categories
        ]);
    }
}


if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}

$title_name = "Вход";
$user_name = $_SESSION['user']['name'];
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories,
    'username' => $_SESSION['user']['name'],
]);
print ($layout_content);