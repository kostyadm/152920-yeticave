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

function time_remaining($end_date)
{
// устанавливаем часовой пояс в Московское время
    date_default_timezone_set('Europe/Moscow');

    $ending = strtotime($end_date);

// временная метка для настоящего времени
    $now = strtotime('now');

    $period = $ending - $now;
    $lot_time_remaining = gmdate("H:i", $period);
    if ($period > 86400) {
        $lot_time_remaining = gmdate("d дней H:i", $period);
    }
    return $lot_time_remaining;
}

function time_format($timestamp)
{
    $time_formated = (strtotime('now') - $timestamp) / 60;
    if ($time_formated > 1440) {
        return $time_string = gmdate("d.m.y в h.i", $timestamp);
    } elseif ($time_formated < 60) {
        return $time_string = round($time_formated) . ' минут назад';
    } else {
        return $time_string = round(($time_formated) / 60) . ' часов назад';
    }
}

function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_picture($photo_upload, $tmp_name)
{
    $jpg = [];
    if (!empty($photo_upload)) {
        $path = uniqid() . '.jpg';
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $jpg['error'] = 'Загрузите картинку в формате jpg';

        } else {
            move_uploaded_file($tmp_name, 'img/uploads/' . $path);
            $jpg['path'] = 'img/uploads/' . $path;
        }
    }
    return $jpg;
}

function validate_lot_input($added_data, $required, $dict, $number)
{
    $errors = [];
    foreach ($added_data as $key => $value) {
        if (in_array($key, $required) && ($value == '' OR $value == 'Выберите категорию')) {
            $errors[$dict[$key]] = 'Это поле необходимо заполнить';
        }
        if ($key == 'lot-date'
            AND (!strtotime($added_data['lot-date'])
                OR strtotime($added_data['lot-date']) < strtotime('now'))) {
            $errors[$dict[$key]] = 'В это поле необходимо вписать корректную дату';
        }
        if (in_array($key, $number)) {
            if (!is_numeric($added_data[$key])) {
                $errors[$dict[$key]] = 'В это поле необходимо вписать числовое значение';
            }
        }
    }
    return $errors;
}

function validate_input_data($input_data)
{
    $errors = [];
    foreach ($input_data as $key => $value) {
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

function fetch_data($con, $sql)
{
    $result = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result;

}

function fetch_array($con, $sql)
{
    $result = mysqli_query($con, $sql);
    $result = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $result;
}

function add_data($con, $sql)
{
    $result['ok'] = mysqli_query($con, $sql);

    if (!$result['ok']) {
        $error = mysqli_error($con);
        $result['error'] = 'Ошибка MySQL: ' . $error;
    }
    return $result;
}

function count_records($con, $table_name)
{
    $sql_count = "SELECT COUNT(id) AS 'records' FROM " . $table_name;
    $records_count = fetch_data($con, $sql_count);
    $new_record = $records_count[0]['records'];

    return $new_record;
}

function get_id($item_name, $array)
{
    foreach ($array as $value) {
        if ($item_name == $value['category']) {
            $id = intval($value['id']);
            break;
        }
    }
    return $id;
}