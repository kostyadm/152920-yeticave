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

function sort_ads($ads=array(), $chosen_category){

    foreach ($ads as $i=>$val) {
        if ($chosen_category != $ads[$i]["category"]) {
            continue;
        }
        else {
            print("
                <li class=\"lots__item lot\">
                    <div class=\"lot__image\">
                        <img src=\"" . $ads[$i]['pic-link'] . "\"  width='350' height='260' alt=" . $ads[$i]['category'] . ">
                    </div>
                    <div class='lot__info'>
                        <span class='lot__category'>" . $ads[$i]['category'] . "</span>
                        <h3 class=\"lot__title\"><a class=\"text-link\" href=\"lot.html\">" . $ads[$i]['name'] . "</a></h3>
                        <div class='lot__state'>
                            <div class='lot__rate'>
                                <span class='lot__amount'> Стартовая цена </span>
                                <span class='lot__cost'>" . $ads[$i]['price'] . "<b class='rub'>р</b> </span>
                            </div>
                            <div class='lot__timer timer'>
                               " .$lot_time_remaining. "
                            </div>
                        </div> 
                    </div>
                <li>
                ");
        }


    }
}
?>
