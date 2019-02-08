<?php
$is_auth = rand(0, 1);
$title_name = "Главная";
$user_name = 'Денис Филипкин';

$equipments = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$announcement = [
    [
      "name" => "2014 Rossignol District Snowboard",
      "category" => "Доски и лыжи",
      "price" => "10999",
      "url" => "img/lot-1.jpg"
    ],
    [
      "name" => "DC Ply Mens 2016/2017 Snowboard",
      "category" => "Доски и лыжи",
      "price" => "159999",
      "url" => "img/lot-2.jpg"
    ],
    [
      "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
      "category" => "Крепление",
      "price" => "8000",
      "url" => "img/lot-3.jpg"
    ],
    [
      "name" => "Ботинки для сноуборда DC Mutiny Charocal",
      "category" => "Ботинки",
      "price" => "10999",
      "url" => "img/lot-4.jpg"
    ],
    [
      "name" => "Куртка для сноуборда DC Mutiny Charocal",
      "category" => "Одежда",
      "price" => "7500",
      "url" => "img/lot-5.jpg"
    ],
    [
      "name" => "Маска Oakley Canopy",
      "category" => "Разное",
      "price" => "5400",
      "url" => "img/lot-6.jpg"
    ],
];
function do_price($price)
{
    $integer_price = ceil($price);
    $integer_price = number_format($integer_price, 0, ',', ' ');
    return $integer_price . " <b class=\"rub\">р</b>";
};

require_once ("functions.php");

$page_content = include_template("index.php", [
        'equipments' => $equipments,
        'announcement' => $announcement
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user' => $user_name,
    'title' => $title_name
]);
print ($layout_content);
?>

