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
    <form enctype="multipart/form-data" class="form form--add-lot container <?=$classname?>" action="add.php" method="post" > <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
          <?php
          $classname = isset($errors["lot-name"]) ? "form__item--invalid" : "";
          ?>
        <div class="form__item <?=$classname?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование</label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите название лота" value="<?=$lot_name_cur = isset($lot_name_cur) ? $lot_name_cur : "";?>" >
          <span class="form__error">Введите наименование лота</span>
        </div>
          <?php
          $classname = isset($errors["categories"]) ? "form__item--invalid" : "";
          ?>
        <div class="form__item <?=$classname;?>">
          <label for="category">Категория</label>

          <select id="category"  name="category" >
            <option><?=$category_cur = isset($category_cur) ? $category_cur : "Выберите категорию";?></option>
              <?php
              foreach ($equipments as $item): ?>
                  <option><?=$item["name"];?></option>
              <?php endforeach; ?>
          </select>
          <span class="form__error"><?=isset($errors["categories"]) ? $errors["categories"] : "";?></span>
        </div>
      </div>
        <?php
        $classname = isset($errors["description"]) ? "form__item--invalid" : "";
        ?>
      <div class="form__item form__item--wide <?=$classname?>">
        <label for="message">Описание</label>
        <textarea id="message" name="description" placeholder="Напишите описание лота" ><?=$description_cur = isset($description_cur) ? $description_cur : "";?></textarea>
        <span class="form__error">Напишите описание лота</span>
      </div>
        <?php
        $classname = isset($errors["photo"]) ? "form__item--invalid" : "";
        ?>
      <div class="form__item form__item--file <?=$classname?>"> <!-- form__item--uploaded -->
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
          <span class="form__error"><?=$errors["photo"];?></span>
      </div>
      <div class="form__container-three">
          <?php
          $classname = isset($errors["start_price"]) ? "form__item--invalid" : "";
          ?>
        <div class="form__item form__item--small <?=$classname?>">
          <label for="lot-rate">Начальная цена</label>
          <input id="lot-rate"  value="<?=$start_price_cur = isset($start_price_cur) ? $start_price_cur : ""; ?>" name="start_price" placeholder="0" >
          <span class="form__error"><?=$errors["start_price"]?></span>
        </div>
          <?php
          $classname = isset($errors["step_price"]) ? "form__item--invalid" : "";
          ?>
        <div class="form__item form__item--small <?=$classname?>">
          <label for="lot-step">Шаг ставки</label>
          <input id="lot-step"  value="<?=$step_price_cur = isset($step_price_cur) ? $step_price_cur : "";?>" name="step_price" placeholder="0" >
          <span class="form__error"><?=$errors["step_price"];?></span>
        </div>
          <?php
          $classname = isset($errors["lot-date"]) ? "form__item--invalid" : "";
          ?>
        <div class="form__item <?=$classname;?>">
          <label for="lot-date">Дата окончания торгов</label>
          <input class="form__input-date" id="close_sale" type="date" name="lot-date" value="<?=$lot_date_cur = isset($lot_date_cur) ? $lot_date_cur : "";?>">
          <span class="form__error"><?=$errors["lot-date"];?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>