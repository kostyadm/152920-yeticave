<form class="lot-item__form" action="my-lots.php" method="post">
    <p class="lot-item__form-item">
        <label for="cost">Ваша ставка</label>
        <input id="cost" type="number" name="cost"
               placeholder="<?=$min_bet;?>">
    </p>
    <input class="visually-hidden" type="text" name="lot_id" value="<?= $id; ?>">
    <input class="visually-hidden" type="text" name="adding_time" value="<?= strtotime('now'); ?>">
    <button type="submit" class="button" href="my-lots.php">Сделать ставку</button>
</form>
