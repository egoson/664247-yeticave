<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($equipments as $item): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=$item["name"];?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php $classname = isset($errors) ? "form--invalid" : "";?>
    <form class="form container <?=$classname;?>" enctype="multipart/form-data" action="sign-up.php" name="signup" method="post"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <?php $classname = isset($errors["email"]) ? "form__item--invalid" : "";?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$values['email'] ?? ''; ?>" >
            <span class="form__error">Введите e-mail</span>
        </div>
        <?php $classname = isset($errors["password"]) ? "form__item--invalid" : "";?>
        <div class="form__item <?=$classname;?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль">
            <span class="form__error">Введите пароль</span>
        </div>
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";?>
        <div class="form__item <?=$classname;?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$values['name'] ?? ''; ?>" >
            <span class="form__error">Введите имя</span>
        </div>
        <?php $classname = isset($errors['contacts']) ? "form__item--invalid" : "";?>
        <div class="form__item <?=$classname;?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться" ><?=$values['contacts'] ?? ''; ?></textarea>
            <span class="form__error">Напишите как с вами связаться</span>
        </div>
        <div class="form__item form__item--file form__item--last">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <?php if (isset($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?=$error;?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>