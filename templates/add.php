<main>
    <nav class="nav">
      <ul class="nav__list container">
          <?php
          foreach ($equipments as $item): ?>
              <li class="nav__item">
                  <a href="all-lots.html"><?=$item["name"];?></a>
              </li>
          <?php endforeach; ?>
      </ul>
    </nav>
    <?php $classname = isset($errors) ? "form--invalid" : "";?>
    <form class="form form--add-lot container <?=$classname?>" action="add.php" method="post"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
          <?php
          $classname = isset($errors["lot-name"]) ? "form__item--invalid" : "";
          $is_set = isset($_POST["lot-name"]) ? $_POST["lot-name"] : "";
          $value = (!$_POST["lot-name"]) ? "Это поле нужно заполнить" : "";
          ?>
        <div class="form__item <?=$classname?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование</label>
          <input id="lot-name" type="text" name="lot-name" placeholder="<?=$value?>" value="<?=$is_set?>" required>
          <span class="form__error">Введите наименование лота</span>
        </div>
          <?php
          $classname = ($_POST["category"]) ? "form__item--invalid" : ""; var_dump($_POST["category"]);
          $is_set = isset($_POST["category"]) ? $_POST["category"] : "";
          ?>
        <div class="form__item <?=$classname;?>">
          <label for="category">Категория</label>

          <select id="category"  name="category" >
            <option><?=$is_set = $is_set ? $is_set : "Выберите категорию"?></option>
              <?php
              foreach ($equipments as $item): ?>
                  <option><?=$item["name"];?></option>
              <?php endforeach; ?>
          </select>
          <span class="form__error"><?=$value?></span>
        </div>
      </div>
        <?php
        $classname = isset($errors["description"]) ? "form__item--invalid" : "";
        $is_set = isset($_POST["description"]) ? $_POST["description"] : "";
        $value = (!$_POST["description"]) ? "Это поле нужно заполнить" : "";
        ?>
      <div class="form__item form__item--wide <?=$classname?>">
        <label for="message">Описание</label>
        <textarea id="message" name="description" placeholder="<?=$value?>" ><?=$is_set?></textarea>
        <span class="form__error">Напишите описание лота</span>
      </div>
      <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" name="photo" type="file" id="photo2" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
      </div>
      <div class="form__container-three">
          <?php
          $classname = isset($errors["start_price"]) ? "form__item--invalid" : "";
          $is_set = isset($_POST["start_price"]) ? $_POST["start_price"] : "";
          $value = (!$_POST["start_price"]) ? "Это поле нужно заполнить" : "";
          ?>
        <div class="form__item form__item--small <?=$classname?>">
          <label for="lot-rate">Начальная цена</label>
          <input id="lot-rate" type="number" value="<?=$is_set?>" name="start_price" placeholder="0" >
          <span class="form__error"><?=$value?></span>
        </div>
          <?php
          $classname = isset($errors["start_price"]) ? "form__item--invalid" : "";
          $is_set = isset($_POST["start_price"]) ? $_POST["start_price"] : "";
          $value = (!$_POST["start_price"]) ? "Это поле нужно заполнить" : "";
          ?>
        <div class="form__item form__item--small <?=$classname?>">
          <label for="lot-step">Шаг ставки</label>
          <input id="lot-step" type="number" value="<?=$is_set?>" name="step_price" placeholder="0" >
          <span class="form__error"><?=$value?></span>
        </div>
        <div class="form__item">
          <label for="lot-date">Дата окончания торгов</label>
          <input class="form__input-date" id="close_sale" type="date" name="lot-date" required>
          <span class="form__error">Введите дату завершения торгов</span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>