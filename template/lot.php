<section class="lot-item container">
    <h2><?=isset($_POST['lot-name']) ? $_POST['lot-name'] : $args['details']['name'];?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=isset($_FILE['path']) ? $_FILE['path'] : $args['details']['pic-link']?>" width="730" height="548" alt="<?=isset($_POST['category']) ? $_POST['category'] : 'Сноуборд'?>">
            </div>
            <p class="lot-item__category">Категория: <span><?=isset($_POST['category']) ? $_POST['category'] : $args['details']['category']?></span></p>
            <p class="lot-item__description"><?=isset($_POST['message']) ? $_POST['message']:'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
                снег
                мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
                снаряд
                отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
                кэмбер
                позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
                просто
                посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
                равнодушным.';?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54:12
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=isset($_POST['lot-rate'] ) ? $_POST['lot-rate'] : $args['details']['price'];?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=isset($_POST['lot-rate']) ? $_POST['lot-rate']+$_POST['lot-step'] :'12 000 р';?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="<?=isset($_POST['lot-rate']) ? $_POST['lot-rate']+$_POST['lot-step'] :'12 000 р';?>">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span>4</span>)</h3>
                <!-- заполните эту таблицу данными из массива $bets-->
                <table class="history__list">
                    <?=$args['bets']?>
                </table>
            </div>
        </div>
    </div>
</section>