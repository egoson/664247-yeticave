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
    <section class="lot-item container">
        <h2><?=htmlspecialchars($lot["name"]);?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src=<?=$lot["image"];?> width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=htmlspecialchars($lot["categories_name"]);?></span></p>
                <p class="lot-item__description"><?=$lot["description"];?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        10:54
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=(do_price(htmlspecialchars($lot["start_price"]))); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=min_rate($lot["r_amount"],$lot["step_price"]); ?></span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                        <p class="lot-item__form-item form__item form__item--invalid">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?=min_rate($lot["r_amount"],$lot["step_price"]); ?>>
                            <span class="form__error">Введите наименование лота</span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <div class="history">
                    <h3>История ставок (<span>6</span>)</h3>
                    <table class="history__list">
                        <?php  foreach ($raties as $rate): ?>
                        <tr class="history__item">
                            <td class="history__name"><?=$rate["name"];?></td>
                            <td class="history__price"><?=do_price($rate["amount"], false);?></td>
                            <td class="history__time">5 минут назад</td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
