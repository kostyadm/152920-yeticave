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

function validate_lot_input($added_data, $required, $dict)
{
    $errors = [];
    foreach ($required as $value) {
        if ($added_data[$value] == '' OR $added_data[$value] == 'Выберите категорию') {
            $errors[$dict[$value]] = 'Это поле необходимо заполнить';
        }
        if (($value == 'lot-rate' OR $value == 'lot-step')
            AND ($added_data[$value] <= 0
                OR !is_numeric($added_data[$value]))) {
            $errors[$dict[$value]] = 'В это поле необходимо вписать числовое значение которое больше 0';
        }
        if ($value == 'lot-date'
            AND (!strtotime($added_data[$value])
                OR strtotime($added_data[$value]) < strtotime('now'))) {
            $errors[$dict[$value]] = 'В это поле необходимо вписать корректную дату не раньше завтрашнего числа';
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

function list_menu($con)
{
    $sql_cat = 'SELECT id, img_cat, category FROM categories ORDER BY id ASC';
    $cat = fetch_data($con, $sql_cat);
//create navigation panel list
    $list_menu = '';
    foreach ($cat as $value) {
        $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
    }
    return $list_menu;
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

function min_bet($id, $con, $lot_data)
{
    //selects max bet value for lot
    $sql_max_bet = 'SELECT lot_id, MAX(bet_value) AS \'current_price\' FROM bet WHERE lot_id=' . $id . ' GROUP BY lot_id ORDER BY lot_id';
    $max_bet = fetch_array($con, $sql_max_bet);

//sets minimum for offers
    $price = $lot_data['starting_price'];
    $min_bet = $price + $lot_data['step'];
    if ($max_bet['lot_id'] == $lot_data['id']) {
        $price = $max_bet['current_price'];
        $min_bet = $price + $lot_data['step'];
    }

    return $min_bet;
}

function insert_my_lots($con, $id)
{
    $sql_my_lots = 'SELECT l.id, l.photo, l.lot_name, l.starting_price, c.category,l.step, l.end_date, b.bet_value, b.reg_date
                    FROM lot l
                    JOIN categories c ON c.id=l.category_id
                    JOIN bet b ON l.id=b.lot_id
                    WHERE b.user_id=' . $id;
    $my_lots = fetch_data($con, $sql_my_lots);

    $added_lot = '';
    foreach ($my_lots as $value) {
        $lot_time_remaining = time_remaining($value['end_date']);
        $lot_name = $value['lot_name'];
        $lot_category = $value['category'];
        $photo = $value['photo'];
        $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['bet_value'], 'time_remaining' => $lot_time_remaining, 'timestamp' => strtotime($value['reg_date']), 'lot_category' => $lot_category, 'photo' => $photo, 'id' => $value['id']]);
    }
    return $added_lot;
}