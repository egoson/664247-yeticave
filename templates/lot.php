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
                <?php if (isset($_SESSION['user']['name']) && !$checked_rate && !$is_users_lot): ?>
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
                            Мин. ставка <span><?=do_price($min_rate); ?></span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="add-rate.php" method="post">
                        <?php $classname = isset($error) ? "form__item--invalid" : "";?>
                        <p class="lot-item__form-item form__item  <?=$classname;?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?=do_price($min_rate); ?>>
                            <span><?=$error = !empty($error) ? $error : "Введите ставку";?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <?php endif; ?>
                <div class="history">
                    <h3>История ставок (<span><?php print(count($raties))?></span>)</h3>
                    <table class="history__list">
                        <?php  foreach ($raties as $rate): ?>
                        <tr class="history__item">
                            <td class="history__name"><?=$rate["name"];?></td>
                            <td class="history__price"><?=do_price($rate["amount"], false);?></td>
                            <td class="history__time"><?=do_time_rate($rate["dt_add"]);?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
