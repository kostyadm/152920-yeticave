<?php
function include_template($filename, $args)
{
    if (file_exists('template/' . $filename)) {
        if (is_array($args)) {
            extract($args);
            ob_start();
            include('template/' . $filename . '');
            $result = ob_get_clean();
        }
    } else {
        $result = '';
    }
    return $result;
}

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('today midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = gmdate("H:i", $tomorrow - $now);

function time_format($timestamp)
{
    $time_formated = (strtotime('now') - $timestamp) / 60;
    if ($time_formated > 1440) {
        return $time_string = gmdate("d.m.y в h.i", $timestamp);
    } elseif ($time_formated < 60) {
        return $time_string = round($time_formated) . ' минут назад';
    } else {
        return $time_string = (round($time_formated) / 60) . ' часов назад';
    }
}

function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_picture($photo_upload)
{
    if (!empty($photo_upload)) {
        $tmp_name = $_FILES['lot_photo']['tmp_name'];
        $path = $_FILES['lot_photo']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $jpg['error'] = 'Загрузите картинку в формате jpg';

        } else {
            move_uploaded_file($tmp_name, 'img/uploads/' . $path);
            $jpg['path'] = $path;
        }
    }
    $jpg['error'] = 'Вы не загрузили файл';
    return $jpg;
}

function validate_lot_input($added_data, $required, $dict, $is_number)
{
    $errors = [];
    foreach ($added_data as $key => $value) {
        if (in_array($key, $required) && ($value == '' OR $value == 'Выберите категорию')) {
            $errors[$dict[$key]] = '- это поле необходимо заполнить';
        }
        if (in_array($key, $is_number)) {
            if (!is_numeric($added_data[$key])) {
                $errors[$dict[$key]] = '- в это поле необходимо вписать числовое значение';
            }
        }
    }
    return $errors;
}

function validate_login_data($login_data)
{
    $errors = [];
    foreach ($login_data as $key => $value) {
        if ($value == '') {
            $errors[$key] = 'Это поле необходимо заполнить';
        } elseif ($key == 'email') {
            if (!validate_email($value)) {
                $errors[$key] = 'Введённый адрес не действителен';
            }
        }
    }
    return $errors;
}

function minimum_bet_value($user_bet, $minimum_value)
{
    if ($user_bet < $minimum_value) {
        return false;
    } else {
        return true;
    }
}






