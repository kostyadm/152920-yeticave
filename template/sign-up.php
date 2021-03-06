<nav class="nav">
    <ul class="nav__list container">
        <?= $list_menu; ?>
    </ul>
</nav>
<form class="form container <?= isset($errors) ? 'form--invalid' : ''; ?>" action="sign-up.php" method="post"
      novalidate enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?= isset($errors['email']) ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail"
               value="<?= isset($sign_up_data['email']) ? $sign_up_data['email'] : ""; ?>" required>
        <span class="form__error"><?= isset($errors['email']) ? $errors['email'] : ""; ?></span>
    </div>
    <div class="form__item <?= isset($errors['password']) ? 'form__item--invalid' : ''; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль"
               value="<?= isset($sign_up_data['password']) ? $sign_up_data['password'] : ""; ?>" required>
        <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item <?= isset($errors['name']) ? 'form__item--invalid' : ''; ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя"
               value="<?= isset($sign_up_data['name']) ? $sign_up_data['name'] : ""; ?>" required>
        <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item <?= isset($errors['message']) ? 'form__item--invalid' : ''; ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"
                  required><?= isset($sign_up_data['message']) ? $sign_up_data['message'] : ""; ?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <div class="form__item form__item--file form__item--last">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?= $jpg['path']; ?>" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="" name="avatar">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>