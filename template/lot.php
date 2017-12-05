<nav class="nav">
    <ul class="nav__list container">
        <?= $list_menu; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?= isset($added_data['lot-name']) ? $added_data['lot-name'] : $details['name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= isset($jpg['path']) ? "img/uploads/" . $jpg['path'] : $details['pic-link'] ?>" width="730"
                     height="548"
                     alt="<?= isset($added_data['category']) ? $added_data['category'] : $details['category']; ?>">
            </div>
            <p class="lot-item__category">Категория:
                <span><?= isset($added_data['category']) ? $added_data['category'] : $details['category'] ?></span></p>
            <p class="lot-item__description"><?= isset($added_data['message']) ? $added_data['message'] : 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
                снег
                мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
                снаряд
                отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
                кэмбер
                позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
                просто
                посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
                равнодушным.'; ?></p>
        </div>
        <div class="lot-item__right">
            <?=$do_offer;?>
            </div>
            <div class="history">
                <h3>История ставок (<span>4</span>)</h3>
                <!-- заполните эту таблицу данными из массива $bets-->
                <table class="history__list">
                    <?= $bets ?>
                </table>
            </div>
        </div>
    </div>
</section>