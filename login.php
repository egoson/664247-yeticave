<?php
require_once ("functions.php");
require_once ("init.php");
session_start();
if(isset($_SESSION["user"]["url"])) {
    $link_to_cur_page = $_SESSION["user"]["url"];
};
$lot = get_lots($link);
$categories =  get_categories($link);
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
    $user = get_user($link, $email);
    if(!count($errors)) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    }
    if ($form['email'] !== $user["email"]) {
        $errors['email'] = "Данный email не существует";
    }
    if (count($errors)) {
        $page_content = include_template('login.php', ['form' => $form, 'errors' => $errors, 'email' => $email, 'equipments' => $categories]);
    }
    else {
        header("Location: /index.php");
        exit();
    }
} else {
    $page_content = include_template("login.php", [
            'equipments' => $categories
    ]);
}
if (!$link) {
    print("Ошибка: невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}
$title_name = "Вход";
$user_name = "";
if (isset($_SESSION['user']['name'])) {
    $user_name = $_SESSION['user']['name'];
}
$_SESSION['user']['name'] = NULL;
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name,
    'equipments' => $categories,
    'username' => $_SESSION['user']['name']
]);
print ($layout_content);