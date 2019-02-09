<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = 'Error. Please restart';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require_once $name;
    $result = ob_get_clean();
    return $result;
};

function do_price($price)
{
    $integer_price = ceil($price);
    $integer_price = number_format($integer_price, 0, ',', ' ');
    return $integer_price . " <b class=\"rub\">р</b>";
};
