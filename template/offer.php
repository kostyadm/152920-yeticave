<div class="lot-item__state">
    <div class="lot-item__timer timer">
        <?=$time?>
    </div>
    <div class="lot-item__cost-state">
        <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?= isset($added_data['lot-rate']) ? $added_data['lot-rate'] : $details['price']; ?></span>
        </div>
        <div class="lot-item__min-cost">
            Мин. ставка
            <span><?= isset($added_data['lot-rate']) ? $added_data['lot-rate'] + $added_data['lot-step'] : '12 000 р'; ?></span>
        </div>
    </div>
    <form class="lot-item__form" action="my-lots.php" method="post">
        <p class="lot-item__form-item">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="number" name="cost"
                   placeholder="<?= isset($added_data['lot-rate']) ? $added_data['lot-rate'] + $added_data['lot-step'] : '12 000 р'; ?>">
        </p>
        <input class="visually-hidden" type="text" name="lot_id" value="<?=$id;?>">
        <input class="visually-hidden" type="text" name="adding_time" value="<?=strtotime('now');?>">
        <button type="submit" class="button" href="my-lots.php">Сделать ставку</button>
    </form>