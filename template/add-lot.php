<nav class="nav">
    <ul class="nav__list container">
        <?= $list_menu; ?>
    </ul>
</nav>

<form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : ""; ?>"
      action="../add-lot.php" method="post"
      enctype="multipart/form-data" novalidate><!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= isset($errors['Наименование']) ? "form__item--invalid" : ""; ?>">
            <!-- form__item--invalid -->
            <label for="lot_name">Наименование</label>
            <input id="lot_name" type="text" name="lot_name"
                   value="<?= isset($added_data['lot_name']) ? $added_data['lot_name'] : ""; ?>"
                   placeholder="Введите наименование лота" required>
            <span class="form__error"><?= isset($errors['Наименование']) ? $errors['Наименование'] : ""; ?></span>
        </div>
        <div class="form__item <?= isset($errors['Категория']) ? "form__item--invalid" : ""; ?>">
            <label for="category">Категория</label>
            <select id="category" name="category" required>
                <option>Выберите категорию</option>
                <?php foreach ($cat as $value): ?>
                    <option value="<?= $value['category'] ?>"
                            <?php if (isset($added_data['category']) && $value['category'] == $added_data['category']): ?>selected="selected" <?php endif; ?>><?= $value['category'] ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?= isset($errors['Категория']) ? $errors['Категория'] : ""; ?></span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= isset($errors['Описание']) ? "form__item--invalid" : ""; ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message"
                  placeholder="Напишите описание лота"
                  required><?= isset($added_data['message']) ? $added_data['message'] : ""; ?></textarea>
        <span class="form__error"> <?= isset($errors['Описание']) ? $errors['Описание'] : ""; ?></span>
    </div>
    <div class="form__item form__item--file <?= isset($jpg['path']) ? "form__item--uploaded" : ""; ?>">
        <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/uploads/<?= $jpg['path']; ?>" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value=""
                   name="lot_photo" required>
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= isset($errors['Начальная цена']) ? "form__item--invalid" : ""; ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="text" name="lot-rate"
                   value="<?= isset($added_data['lot-rate']) ? $added_data['lot-rate'] : ""; ?>"
                   placeholder="0" required>
            <span class="form__error"><?= isset($errors['Начальная цена']) ? $errors['Начальная цена'] : ""; ?></span>
        </div>
        <div class="form__item form__item--small <?= isset($errors['Шаг ставки']) ? "form__item--invalid" : ""; ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="text" name="lot-step"
                   value="<?= isset($added_data['lot-step']) ? $added_data['lot-step'] : ""; ?>"
                   placeholder="0" required>
            <span class="form__error"><?= isset($errors['Шаг ставки']) ? $errors['Шаг ставки'] : ""; ?></span>
        </div>
        <div class="form__item <?= isset($errors['Дата окончания торгов']) ? "form__item--invalid" : ""; ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="text" name="lot-date"
                   value="<?= isset($added_data['lot-date']) ? $added_data['lot-date'] : ""; ?>" required>
            <span class="form__error"><?= isset($errors['Дата окончания торгов']) ? $errors['Дата окончания торгов'] : ""; ?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">
        Пожалуйста, исправьте ошибки в форме.

    </span>
    <button type="submit" class="button">Добавить лот</button>
</form>