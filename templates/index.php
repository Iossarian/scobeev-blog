    <section class="promo">
        <h2 class="promo__title">Приветствуем тебя в нашем блоге</h2>
        <p class="promo__text">Здесь мы обсуждаем бороды и все, что с ними связано.</p>
        <p class="promo__text">Список категорий</p>
        <ul class="promo__list" >

            <?php foreach ($category_array as $value) { ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="#"> <?=$value['category_name']; ?> </a>
                </li>
                <?php
            }
            ?>
        </ul >
        <p class="promo__text">Список тэгов</p>
        <ul class="promo__list" >

            <?php foreach ($tags_array as $value):?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="#"> <?=$value['tag_name']; ?> </a>
                </li>
            <?php endforeach; ?>
        </ul >


    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Все записи</h2>
        </div>
        <ul class="lots__list">
         <?php foreach ($posts_array as $value) { ?>
                <li class="lots__item lot">
                     <?php if(isset($value['image'])): ?>
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($value['image']); ?>" width="350" height="260" alt="">
                    </div>
                     <?php endif; ?>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($value['category_name']) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="post.php?id=<?=$value['id'];?>"><?= htmlspecialchars($value['name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">

                                <span class="lot__amount">Автор</span>
                                <h3 class="lot__title"><?= htmlspecialchars($value['name']); ?></h3>
                                <span class="lot__cost"></span>
                            </div>
                            <div class="lot__rate">

                                <span class="lot__amount">Тэги</span>
                                <h3 class="lot__title"><?= htmlspecialchars($value['tag_name']); ?></h3>
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
