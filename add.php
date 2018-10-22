<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM categories";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);


//Запрос на добавление записи
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = isset($_POST['lot']) ? $_POST['lot'] : null;
    $user_id = $_SESSION['user']['id'];
    $allowed_img_types = ['image/png', 'image/jpeg'];
//Валидация
    $required = ['name', 'category_id', 'description'];
    $dict = [
        'name' => 'Название записи',
        'category_id' => 'Категория записи',
        'description' => 'Описание записи',
        'image' => 'Ошибка загрузки изображения: ',
    ];
    $valid_errors = [];

//Проверка заполненности полей
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $valid_errors[$key] = 'Это поле необходимо заполнить';
        }
    }
//Проверка файла
    isset($valid_errors['image']) ? $valid_errors['image'] : null;
    if (!empty($_FILES['image']['name'])) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $filename = 'img' . DIRECTORY_SEPARATOR . uniqid() . '.jpg';
        $lot['image'] = $filename;
        if (!in_array($file_type, $allowed_img_types)) {
            $valid_errors['image'] = 'Загрузите картинку в формате JPEG';
        } else {
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $filename);
        }
    }




    if (count($valid_errors) <= 0) {
        if (isset($lot['image'])) {
            $sql_post = 'INSERT INTO post (creation_date, author_id, category_id, name, description,  image, tags ) VALUES (NOW(), ?, ?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql_post, [$user_id, $_POST['category_id'], $_POST['name'], $_POST['description'], $lot['image'], $_POST['tags']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                $post_id = mysqli_insert_id($con);
                header("Location: lot.php?id=" . $post_id);
            }
        } else {
            $sql_post = 'INSERT INTO post (creation_date, author_id, category_id, name, description, tags) VALUES (NOW(), ?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql_post, [$user_id, $_POST['category_id'], $_POST['name'], $_POST['description'], $_POST['tags']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                $post_id = mysqli_insert_id($con);
                header("Location: lot.php?id=" . $post_id);
            }

        }
    }
}

$addLot_content = include_template ('add-lot.php', [
    'valid_errors' => $valid_errors ?? [],
    'dict' => $dict ?? [],
    'category_array' => $category_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $addLot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Boradach - Добавление записи'
]);
echo $layout_content;
?>


