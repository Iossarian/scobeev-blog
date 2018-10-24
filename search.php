<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM categories";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);

$search = trim($_GET['search']);
$safe_search = mysqli_real_escape_string($con, $search);
$error = [];

if ($safe_search && $safe_search !== '') {
    $sql_s = "SELECT post.id, name, description, image, category_name, tag_name FROM post"
        . " JOIN categories ON categories.id = post.category_id"
        . " JOIN tags ON tags.id = post.tag_id"
        . " WHERE MATCH(name, description) AGAINST(?)"
        . "ORDER BY creation_date DESC";

    $stmt = db_get_prepare_stmt($con, $sql_s, [$safe_search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!count($posts)) {
        $error['search'] = 'По вашему запросу ничего не найдено';
    }
}
if (empty($search)) {
    $error['search'] = 'Введите поисковой запрос';
}
$addLot_content = include_template ('search.php', [
    'category_array' => $category_array,
    'posts' => $posts ?? '',
    'safe_search' => $safe_search,
    'error' => $error ?? ''
]);
$layout_content = include_template ('layout.php', [
    'content' => $addLot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Borodach - Поиск'
]);
echo $layout_content;
?>