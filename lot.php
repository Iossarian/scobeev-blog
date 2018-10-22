<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM categories";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Подключение лотов
$sql_post = "SELECT post.id, name, image, category_name FROM post
            JOIN categories ON categories.id = post.category_id
            ORDER BY creation_date DESC";
$sql_post_result = mysqli_query($con, $sql_post);
$posts_array = mysqli_fetch_all($sql_post_result, MYSQLI_ASSOC);
//Подключение параметра запроса
$id = intval($_GET['id']);
$sql_l =    "SELECT post.id, name, image, category_name, description, tags FROM post "
            . "JOIN categories ON categories.id = post.category_id "
            . "WHERE post.id = " .$id;

if ($result = mysqli_query($con, $sql_l)) {
    if (!mysqli_num_rows($result)) {
        http_response_code(404);
    } else {
        $post = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}
//Подключение комментариев
$com_sql = 'SELECT comments.id,
            comments.date AS date, 
            comments.comment AS comment ,
            comments.post_id AS ID,
            comments.user_id,
            users.name AS user_name
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id  = "' .$id. '"
            ORDER BY date DESC;';
$com_query_result=mysqli_query($con, $com_sql);
if(!$com_query_result) {
    $error = mysqli_error($con);
    print("Ошибка MySQL: " . $error);
    die();}
$com_query_array=mysqli_fetch_all($com_query_result, MYSQLI_ASSOC);
$res = mysqli_query($con, $com_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error =[];
    $user_id = $_SESSION['user']['id'];
    $post_com = $_POST['com'];

    if (!empty($_POST['com'])) {
        $sql = 'INSERT INTO comments (date, comment, post_id, user_id) VALUES (NOW(), ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, [$post_com, $id, $user_id]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: lot.php?id=" . $id);
            exit();
        }
    } else {
        $error['com'] = 'Введите комментарий';
    }
    if (isset($_POST['del'])) {
        $sql = 'DELETE * FROM post WHERE id = "' .$id. '";';
        $res = mysqli_query ($con, $sql);
    }
}d

$lot_content = include_template ('lot.php', [
    'category_array' => $category_array,
    'posts_array' => $posts_array,
    'post' => $post ?? [],
    'id' => $id,
    'error' => $error ?? [],
    'com_query_array' => $com_query_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $lot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Botodach - Просмотр записи'
]);

echo $layout_content;













?>