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
function do_time_to_cell()
{
    $ts = time();
    $ts_midnight = strtotime('tomorrow');
    $time_to_midnight = $ts_midnight - time();
    $hours = floor($time_to_midnight / 3600);
    $minutes = floor(($time_to_midnight % 3600) / 60);
    return $hours . ":" . sprintf('%02d', $minutes);
}
