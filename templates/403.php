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
    <section class="lot-item container">
        <h2>403 Пожалуйста авторизуйтесь</h2>
        <p>Вы не авторизованы.</p>
    </section>
</main>