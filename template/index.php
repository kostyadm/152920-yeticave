<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach($args['cat'] as $key=>$value):?>
            <li class="promo__item promo__item--<?=$key?>">
                <a class="promo__link" href="index.php?category=<?=$key?>"><?=$value;?></a>
            </li>
        <?endforeach;?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php
        $chosen_category="";
        if (isset($_GET['category'])){
         if ($_GET['category']=='boards'){
            $chosen_category='Доски и лыжи';
        }   elseif($_GET['category']=='attachment'){
            $chosen_category='Крепления';
        }   elseif($_GET['category']=='tools'){
            $chosen_category='Инструменты';
        }   elseif($_GET['category']=='boots'){
            $chosen_category='Ботинки';
        }   elseif($_GET['category']=='clothing') {
            $chosen_category='Одежда';
        }   elseif($_GET['category']=='other'){
            $chosen_category='Разное';
        }
        }
        else {
        foreach ($args['lot_data'] as $key => $val) : ?>

        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?= $val['pic-link'] ?>" width='350' height='260'
                     alt="<?= $val['category'] ?>">
            </div>
            <div class='lot__info'>
                <span class='lot__category'><?= $val['category'] ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$key?>"><?= $val['name'] ?></a></h3>
                <div class='lot__state'>
                    <div class='lot__rate'>
                        <span class='lot__amount'> Стартовая цена </span>
                        <span class='lot__cost'><?= $val['price'] ?> <b class='rub'>р</b> </span>
                    </div>
                    <div class='lot__timer timer'>
                        <?= $args['time'] ?>
                    </div>
                </div>
            </div>
        <li>
            <?php
            endforeach;}

            sort_lot($args['lot_data'],$chosen_category,$args['time']);
        ?>
    </ul>
</section>
