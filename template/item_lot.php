<li class="lots__item lot">
            <div class="lot__image">
                <img src="<?= $lot_data['photo'] ?>" width='350' height='260'
                     alt="<?= $lot_data['category'] ?>">
            </div>
            <div class='lot__info'>
                <span class='lot__category'><?=$lot_data['category']?></span>
<h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot_data['id'];?>"><?= $lot_data['lot_name'] ?></a></h3>
<div class='lot__state'>
    <div class='lot__rate'>
        <span class='lot__amount'> Стартовая цена </span>
        <span class='lot__cost'><?= $price ?> <b class='rub'>р</b> </span>
    </div>
    <div class='lot__timer timer'>
        <?= $time ?>
    </div>
</div>
</div>
<li>