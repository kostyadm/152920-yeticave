<?php
function include_template($filename, $args = array())
{
    if (file_exists('template/' . $filename)) {
        ob_start();
        include('template/' . $filename . '');
        $result = ob_get_clean();
    } else {
        $result = '';
    }
    return $result;
}

function user_status($is_auth, $user_name = '', $user_avatar = '')
{
    if ($is_auth) {
        $auth_status = include_template('auth_user.php', ['name' => $user_name, 'avatar' => $user_avatar]);
    } else {
        $auth_status = include_template('non_auth_user.php', []);
    }
    return $auth_status;
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
        return $time_string = $time_formated . ' минут назад';
    } else {
        return $time_string = (round($time_formated) / 60) . ' часов назад';
    }
}

function main_categories_menu($cat = array())
{
    $result = '';
    foreach ($cat as $key => $value):
        $result .= include_template('main_menu_category.php', ['key' => $key, 'name' => $value]);
    endforeach;
    return $result;
}


function list_lots($lot_data = array(), $time)
{
    $result = '';
    foreach ($lot_data as $key => $val):
        $result .= include_template('item_lot.php', ['lot_data' => $val, 'key' => $key, 'time' => $time]);
    endforeach;
    return $result;
}

function sort_lots($lot_data = array(), $cat = array(), $chosen_category, $time)
{
    $result = '';
    foreach ($lot_data as $key => $val) {
        if ($cat[$chosen_category] == $lot_data[$key]["category"]) {
            $result .= include_template('item_lot.php', ['lot_data' => $val, 'key' => $key, 'time' => $time]);
        }
    }
    return $result;
}

function nav_list_menu($cat = array())
{
    $list_menu = '';
    foreach ($cat as $key => $value):
        $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
    endforeach;
    return $list_menu;
}

function print_lot($lot_data = array(), $bets = array())
{
    if (isset ($_GET['id'])) {
        $id = $_GET['id'];
    }
    $bets_return = '';
    foreach ($bets as $bet => $row):
        $bets_return .= include_template('bets.php', ['bet' => $row]);
    endforeach;
    $chosen_lot = include_template('lot.php', ['details' => $lot_data[$id], 'bets' => $bets_return]);
    return $chosen_lot;
}

function validate_number($value)
{
    return filter_var($value, FILTER_VALIDATE_INT);
}

function validate_picture($jpg)
{
    if (isset($_FILES['lot_photo']['name'])) {
        $tmp_name = $_FILES['lot_photo']['tmp_name'];
        $path = $_FILES['lot_photo']['name'];
        $res = move_uploaded_file($tmp_name, 'img/uploads/' . $path);

        if ($res) {
            $jpg['path'] = 'img/uploads/'.$path.'.jpg';
        }

    } else {
        $errors['Файл'] = 'Вы не загрузили файл';
    }
}

function validate_lot_input($required, $is_number, $dict, $jpg, $errors,$cat, $nav_menu, $lot_data, $bets)
{
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && ($value == '' OR $value == 'Выберите категорию')) {
            $errors[$dict[$key]] = '- это поле необходимо заполнить';
        }
        if (in_array($key, $is_number)) {
            if (!is_numeric($_POST[$key])) {
                $errors[$dict[$key]] = '- в это поле необходимо вписать числовое значение';
            }
        }
    }

    validate_picture($jpg);
        $result='';
    if (count($errors) > 0) {
        $result .= include_template('add-lot.php', ['post_data' => $_POST, 'jpg' => $jpg, 'errors' => $errors, 'cat'=>$cat, 'nav-menu'=>$nav_menu]);
    } else {
        $result .= print_lot($lot_data, $bets);
    }
    return $result;
}




