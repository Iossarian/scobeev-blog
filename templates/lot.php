<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($category_array as $value) { ?>
            <li class="nav__item">
                <a href="all-lots.php"> <?=$value['category_name']; ?> </a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
    <section class="lot-item container">
      <h2><?= htmlspecialchars($post['name']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= htmlspecialchars($post['image']); ?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?= htmlspecialchars($post['category_name']); ?></span></p>
          <p class="lot-item__description"><?= htmlspecialchars($post['description']); ?></p>
            <p class="lot-item__category">Тэги: <span></span></p>
            <p class="lot-item__description"><?= htmlspecialchars($post['tags']); ?></p>
        </div>
        <div class="lot-item__right">

          <div class="lot-item__state">
              <?php if(isset($_SESSION['user'])): ?>
            <form class="lot-item__form" action="../lot.php?id=<?=$id;?>" method="post">
                <?php $classname = isset($error['com']) ? "--invalid" : "";?>
              <p class="lot-item__form-item <?=$classname;?>">
                <label for="com">Ваш комментарий</label>
                  <textarea name="com" id="com" cols="33" rows="8"></textarea>
                  <button type="submit" class="button">Комментировать</button>
                  <button type="submit" name="del" class="button">Удалить пост</button>
              </p>
            </form>
              <?php endif; ?>
              <?php if(!empty($error['com'])): ?>
                  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
                  <ul>
                      <div style="color: red; font-size: 14px;"> <?=$error['com'];?></div>
                  </ul>
              <?php endif; ?>
          </div>
          <div class="history">
              <?php if (isset($com_query_array)):  ?>
            <h3>Комментарии (<span><?=count($com_query_array);?></span>)</h3>
              <?php endif; ?>
            <table class="history__list">
                <?php foreach($com_query_array as $key=>$val): ?>
              <tr class="history__item">
                <td class="history__name"><?=$val['user_name'];?></td>
                <td class="history__price"><?=($val['comment']);?></td>
                  <td class="history__time"><?php print(formatComTime($val['date']));?></td></td>
              </tr>
                <?php endforeach; ?>
            </table>

          </div>
        </div>
      </div>
    </section>