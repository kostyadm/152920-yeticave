<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?=$main_menu;?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?=($lots_list);?>
    </ul>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="index.php?page=<?=$cur_page-1?>">Назад</a></li>
        <?=$pagination?>
        <li class="pagination-item pagination-item-next"><a href="index.php?page=<?=$cur_page+1?>">Вперед</a></li>
    </ul>
</section>
