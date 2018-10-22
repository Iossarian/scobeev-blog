    <nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($category_array as $value) { ?>
            <li class="nav__item">
                <a href="/all-lots.php"><?= $value['category_name']; ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    </nav>
    <?php $classname = !empty($errors) ? "--invalid" : ""; ?>
    <form class="form container <?=$classname;?>" action="../login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
        <?php $classname = !empty($errors['email']) ? "form__item--invalid" : "";
        $value = isset($form['email']) ? $form['email'] : ""; ?>
      <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
        <span class="form__error"><?=$errors['email'];?></span>

      </div>
        <?php $classname = !empty($errors['password']) ? "form__item--invalid" : "";
        $value = isset($form['password']) ? $form['password'] : ""; ?>
      <div class="form__item form__item--last <?=$classname;?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required>
        <span class="form__error"><?=$errors['password'];?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
