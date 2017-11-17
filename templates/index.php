<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach($cat as $key=>$value):?>
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
            $b="";
            if  ($_GET['category']=='boards'){
                $b='Доски и лыжи';
                sort_ads();
            }   elseif($_GET['category']=='attachment'){
                $b='Крепления';
                sort_ads();
            }   elseif($_GET['category']=='tools'){
                $b='Инструменты';
                sort_ads();
            }   elseif($_GET['category']=='boots'){
                $b='Ботинки';
                sort_ads();
            }   elseif($_GET['category']=='clothing') {
                $b='Одежда';
                sort_ads();
            }   elseif($_GET['category']=='other'){
                $b='Разное';
                sort_ads();
            }
            else {
            foreach ($ads as $key => $val) : ?>

            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $ads[$key]['pic-link'] ?>" width='350' height='260'
                         alt="<? $ads[$key]['category'] ?>">
                </div>
                <div class='lot__info'>
                    <span class='lot__category'><?= $ads[$key]['category'] ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.html"><?= $ads[$key]['name'] ?></a></h3>
                    <div class='lot__state'>
                        <div class='lot__rate'>
                            <span class='lot__amount'> Стартовая цена </span>
                            <span class='lot__cost'><?= $ads[$key]['price'] ?> <b class='rub'>р</b> </span>
                        </div>
                        <div class='lot__timer timer'>
                            <?= $lot_time_remaining ?>
                        </div>
                    </div>
                </div>
            <li>
                <?php
                endforeach;}
                ?>



        </ul>
    </section>
</main>
