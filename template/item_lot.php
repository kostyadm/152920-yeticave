<li class="lots__item lot">
            <div class="lot__image">
                <img src="<?= $args['lot_data']['pic-link'] ?>" width='350' height='260'
                     alt="<?= $args['lot_data']['category'] ?>">
            </div>
            <div class='lot__info'>
                <span class='lot__category'><?= $args['lot_data']['category'] ?></span>
<h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$args['key'];?>"><?= $args['lot_data']['name'] ?></a></h3>
<div class='lot__state'>
    <div class='lot__rate'>
        <span class='lot__amount'> Стартовая цена </span>
        <span class='lot__cost'><?= $args['lot_data']['price'] ?> <b class='rub'>р</b> </span>
    </div>
    <div class='lot__timer timer'>
        <?= $args['time'] ?>
    </div>
</div>
</div>
<li>