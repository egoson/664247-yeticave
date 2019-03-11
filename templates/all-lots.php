<div class="container">
    <section class="lots">
        <h2>Все лоты в категории <span><?=$lots[0]["category_name"];?></span></h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$lot["image"];?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$lot["category_name"];?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?=$lot["id"];?>"><?=htmlspecialchars($lot["name"]);?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=do_price($lot["start_price"]);?></span>
                        </div>
                        <div class="lot__timer timer">
                            <?=do_time_to_cell($lot["dt_close"])?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination__item--active"><a href="all-lots.php?category_id=/page="></a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>