<?php
function include_template($filename, $args=array()){
    if(file_exists('template/'.$filename)){
        ob_start();
        include ('template/'.$filename.'');
        $result=ob_get_clean();
    }else{
        $result='';
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

function sort_lot($lot_data=array(), $chosen_category,$time){

    foreach ($lot_data as $i=>$val) {
        if ($chosen_category != $lot_data[$i]["category"]) {
            continue;
        }
        else {
            print("
                <li class=\"lots__item lot\">
                    <div class=\"lot__image\">
                        <img src=\"" . $lot_data[$i]['pic-link'] . "\"  width='350' height='260' alt=" . $lot_data[$i]['category'] . ">
                    </div>
                    <div class='lot__info'>
                        <span class='lot__category'>" . $lot_data[$i]['category'] . "</span>
                        <h3 class=\"lot__title\"><a class=\"text-link\" href=\"lot.php?id=$i\">" . $lot_data[$i]['name'] . "</a></h3>
                        <div class='lot__state'>
                            <div class='lot__rate'>
                                <span class='lot__amount'> Стартовая цена </span>
                                <span class='lot__cost'>" . $lot_data[$i]['price'] . "<b class='rub'>р</b> </span>
                            </div>
                            <div class='lot__timer timer'>
                               " .$time. "
                            </div>
                        </div> 
                    </div>
                <li>
                ");
        }


    }
}

function print_lot($lot_data=array(), $bets=array()){
    if (isset ($_GET['id'])){
        $id=$_GET['id'];}
    $chosen_lot = include_template('lot.php', ['details' => $lot_data, 'id' => $id, 'bets' => $bets]);
    print ($chosen_lot);
}
