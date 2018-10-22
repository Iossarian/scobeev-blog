<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($category_array as $value) { ?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?= $value['category_name']; ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
    <div class="container">
      <section class="lots">
          <?php if (!empty($posts)): ?>
        <h2>Результаты поиска по запросу «<span><?=$safe_search;?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($posts as $value) { ?>
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
                                <span class="lot__amount">Тэги</span>
                                <span class="lot__cost"><?= htmlspecialchars($value['tags']); ?></span>
                            </div>
                            <div class="lot__timer timer">
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <?php foreach($error as $err): ?>
                    <h2><li><strong><?=$err;?></strong></li></h2>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
      </section>

    </div>