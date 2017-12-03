<nav class="nav">
    <ul class="nav__list container">
        <?= $list_menu; ?>
    </ul>
</nav>


    <form class="form container <?=isset($errors) ? 'form--invalid':'';?>" action="login.php" method="post" novalidate> <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?=isset($errors['email']) ? 'form__item--invalid':'';?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= isset($login_data['email']) ? $login_data['email']: "";?>" required>
            <span class="form__error"><?=$errors['email']?></span>
        </div>
        <div class="form__item form__item--last <?=isset($errors['password']) ? 'form__item--invalid':'';?>">
            <label for="password">Пароль*</label>
            <input id="password"  type="text" name="password" placeholder="Введите пароль" required>
            <span class="form__error"><?=$errors['password']?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>


