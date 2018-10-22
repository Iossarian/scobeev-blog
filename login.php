<?php
require_once ('db.php');
require_once ('functions.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM categories";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Аутентификация
if($_SERVER['REQUEST_METHOD'] =='POST') {
    $form = isset($_POST) ? $_POST : null;
    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if(empty($form[$field])) {
            $errors[$field] = 'Это поле обязательно к заполнению';
        }
    }
    $email = mysqli_real_escape_string($con, $form['email']);
    $sql_email = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql_email);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if(!count($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такого пользователя не существует';
    }
    if (!count($errors)) {
        $is_auth = 1;
        header("Location: /index.php");
        exit;
    }
} else {
    if (isset($_SESSION['user'])) {
        $content = include_template('welcome.php', ['username' => $_SESSION['user']['name']]);
    }
}



$content =  include_template('login.php', [
    'category_array' => $category_array,
    'errors' => $errors ?? []
]);
$layout_content = include_template ('layout.php', [
    'title' => 'Вход в аккаунт',
    'content' => $content,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'category_array' => $category_array
]);
echo $layout_content;
?>
