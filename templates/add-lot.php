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
        <?php $classname = isset($valid_errors) ? "--invalid" : ""; ?>
        <form class="form form--add-lot container form--invalid" action="../add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
            <h2>Добавление записи</h2>
            <div class="form__container-two">
                <?php $classname = isset($valid_errors['name']) ? "form__item--invalid" : "";
                $value = isset($_POST['name']) ? $_POST['name'] : ""; ?>
                <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
                    <label for="lot-name">Наименование</label>
                    <input id="lot-name"  type="text" name="name" placeholder="Введите название поста" value="<?=$value;?>" required>
                    <span class="form__error">Введите название поста</span>
                </div>
                <?php $classname = isset($valid_errors['category_id']) ? "form__item--invalid" : "";
                $value = isset($_POST['category_id']) ? $_POST['category_id'] : ""; ?>
                <div class="form__item <?=$classname;?>">
                    <label for="category">Категория</label>
                    <select id="category" name="category_id"  required>
                        <option  value="">Выберите категорию</option>
                        <?php foreach ($category_array as $value):?>
                            <option <?=(isset($_POST['category_id']) && $_POST['category_id'] === $value['id'])?'selected':''?> value="<?=$value['id']?>"><?=$value['category_name']?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form__error">Выберите категорию</span>
                </div>
            </div>
            <?php $classname = isset($valid_errors['description']) ? "form__item--invalid" : "";
            $value = isset($_POST['description']) ? $_POST['description'] : ""; ?>
            <div class="form__item form__item--wide <?=$classname;?>">
                <label for="message">Текст поста</label>
                <textarea id="message" name="description" value="" placeholder="Начните писать здесь" required><?=$value;?></textarea>
                <span class="form__error">Напишите текст поста</span>
            </div>
            <?php $classname = isset($valid_errors['image']) ? "form__item--invalid" : "";
            $value = isset($_POST['image']) ? $_POST['image'] : ""; ?>
            <div class="form__item <?=$classname;?> form__item--file "> <!-- form__item--uploaded -->
                <label>Изображение</label>
                <div class="preview">
                    <button class="preview__remove" type="button">x</button>
                    <div class="preview__img">
                        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                    </div>
                </div>
                <div class="form__input-file">
                    <input class="visually-hidden" type="file" name="image" id="photo2" >
                    <label for="photo2">
                        <span>+ Добавить</span>
                    </label>
                </div>
            </div>
            <div class="form__container-three">
                <?php $classname = isset($valid_errors['tags']) ? "form__item--invalid" : "";
                $value = isset($_POST['tags']) ? $_POST['tags'] : ""; ?>
                <div class="form__item <?=$classname;?> form__item--small">
                    <label for="lot-rate">Тэги поста (через запятую)</label>
                    <input id="lot-rate"   name="tags" placeholder="Напишите тэги" value="<?=$value;?>" required>
                    <span class="form__error">Введите тэги здесь</span>
                </div>
            </div>
                    <?php if (!empty($valid_errors)): ?>
            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме:</span>
                <ul>
                    <?php foreach($valid_errors as $err => $val): ?>
                        <li><strong><?=$dict[$err];?></strong> <?=$val;?></li>
                    <?php endforeach; ?>
                </ul>
                    <?php endif; ?>
            <button type="submit" class="button">Добавить пост</button>
        </form>
