<?php
date_default_timezone_set("Europe/Moscow");
require_once ('db.php');
require_once ('functions.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM categories";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Подключение записей
$sql_post = "SELECT post.id, name, image, category_name FROM post
            JOIN categories ON categories.id = post.category_id
            ORDER BY creation_date DESC";
$sql_posts_result = mysqli_query($con, $sql_post);
$posts_array = mysqli_fetch_all($sql_posts_result, MYSQLI_ASSOC);


$page_content = include_template('index.php', [
    'category_array' => $category_array,
    'posts_array' => $posts_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'category_array' => $category_array,
    'title' => 'BorogachBlog - Главная страница'
]);
echo $layout_content;
?>
