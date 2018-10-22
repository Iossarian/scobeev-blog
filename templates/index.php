    <section class="promo">
        <h2 class="promo__title">Приветствуем тебя в нашем блоге</h2>
        <p class="promo__text">Здесь мы обсуждаем бороды и все, что с ними связано.</p>

        <ul class="promo__list" >
            <?php foreach ($category_array as $value) { ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="#"> <?=$value['category_name']; ?> </a>
                </li>
                <?php
            }
            ?>
        </ul >


    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Все записи</h2>
        </div>
        <ul class="lots__list">
         <?php foreach ($posts_array as $value) { ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($value['image']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($value['category_name']) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value['id'];?>"><?= htmlspecialchars($value['name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"></span>
                                <span class="lot__cost"></span>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </section>
