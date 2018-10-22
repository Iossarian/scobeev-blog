<?php
require_once ('db.php');
require_once ('functions.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM categories";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Регистрация
$tpl_data = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST['signup'];
    $errors = [];
    $allowed_img_types = ['image/png', 'image/jpeg'];

    $required = ['password', 'name'];
    $dict = [
        'email' => 'Электронный адрес',
        'password' => 'Ваш пароль',
        'name' => 'Ваше имя'
    ];
    foreach ($required as $key) {
        if (empty($form[$key])) {
            $errors[$key] = '- поле, необходимое к заполнению';
        }
    }
    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    if (empty($form['email'])) {
        $errors['email'] = '- поле, необходимое к заполнению';

    } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'должен быть корректен';
    } elseif (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'уже занят. Пожалуйста, выберите другой.';
    } else {
        if (!empty($_FILES["signup"]['name']['profile_img'])) {
            $tmp_name = $_FILES["signup"]['tmp_name']['profile_img'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            $filename = 'img' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . uniqid()  . '.jpg';
            $_POST['profile_img'] = $filename;
            if (!in_array($file_type, $allowed_img_types)) {
                $errors['profile_img'] = 'Загрузите изображение в формате JPEG или PNG';
            } else {
                move_uploaded_file($_FILES["signup"]['tmp_name']['profile_img'], __DIR__ . DIRECTORY_SEPARATOR . $filename);
            }
        }
        $password = password_hash($form['password'], PASSWORD_DEFAULT);


    }
    if (empty($errors)) {
        if (isset($_POST['profile_img'])) {
            $sql = 'INSERT INTO users (reg_date, email, name, password, profile_img, contacts) VALUES (NOW(), ?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password, $_POST['profile_img'], $form['message']]);
            $res = mysqli_stmt_execute($stmt);
            header("location: /login.php");
            exit();
        } else {
            $sql = 'INSERT INTO users (reg_date, email, name, password, contacts) VALUES (NOW(), ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password, $form['message']]);
            $res = mysqli_stmt_execute($stmt);
            header("location: /login.php");
            exit();
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;


}

$content =  include_template('sign-up.php', [
    'category_array' => $category_array,
    'errors' => $errors ?? [],
    'dict' => $dict ?? [],
    $tpl_data
]);
$layout_content = include_template ('layout.php', [
    'title' => 'Регистрация аккаунта',
    'content' => $content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img']
]);
echo $layout_content;
?>