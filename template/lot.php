<nav class="nav">
    <ul class="nav__list container">
        <?= $list_menu; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?= $lot_data['lot_name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot_data['photo'] ?>" width="730"
                     height="548"
                     alt="<?=$lot_data['category']; ?>">
            </div>
            <p class="lot-item__category">Категория:
                <span><?= $lot_data['category'] ?></span></p>
            <p class="lot-item__description"><?= $lot_data['description']; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?= $time ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= $price; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка
                        <span><?= $min_bet; ?></span>
                    </div>
                </div>
            <?=$do_offer;?>
            </div>
            <div class="history">
                <h3>История ставок (<span><?=$number?></span>)</h3>
                <!-- заполните эту таблицу данными из массива $bets-->
                <table class="history__list">
                    <?= $bets ?>
                </table>
            </div>
        </div>
    </div>
</section>