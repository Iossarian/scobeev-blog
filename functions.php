<?php
require_once ('db.php');

/**
 * //Функция-шаблонизатор
 * @param $name
 * @param $data
 * @return false|string
 */
 function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';
    if (!file_exists($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require_once $name;
    $result = ob_get_clean();
    return $result;
}
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных.
 *
 * @param mysqli $con Ресурс соединения
 * @param string $sql  SQL запрос с плейсхолдерами вместо значений
 * @param array  $data Данные для вставки на место плейсхолдеров
 *
 * @throws \UnexpectedValueException Если тип параметра не поддерживается
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt(mysqli $con, string $sql , array $data = [])
{
    $stmt = mysqli_prepare($con, $sql );
    if (empty($data)) {
        return $stmt;
    }
    static $allowed_types = [
        'integer' => 'i',
        'double' => 'd',
        'string' => 's',
    ];
    $types = '';
    $stmt_data = [];
    foreach ($data as $value) {
        $type = gettype($value);
        if (!isset($allowed_types[$type])) {
            throw new \UnexpectedValueException(sprintf ('Unexpected parameter type "%s".', $type));

        }
        $types .= $allowed_types[$type];
        $stmt_data[] = $value;
    }
    mysqli_stmt_bind_param($stmt, $types, ...$stmt_data);
    return $stmt;
}

/**
 * //Создание сессии
 * @return array
 */
function startTheSession() {
    session_start();
    $sesUser = [];
    if (!empty($_SESSION['user'])) {
        $sesUser['username'] = $_SESSION['user']['name'];
        $sesUser['profile_img'] = $_SESSION['user']['profile_img'];
        $sesUser['user_id'] = $_SESSION['user']['id'];
    }
    else {
        $sesUser['username'] = $sesUser['profile_img'] = NULL;
    }
    return $sesUser;
}
/**
 * //Форматирование времени лота
 * @param $time
 * @return string
 */
function formatComTime($time) {
    $diff_sec = time() - strtotime($time);
    $days = floor($diff_sec / 86400);
    $hours = floor(($diff_sec % 86400) / 3600);
    $minutes = floor(($diff_sec % 3600) / 60);
    if ($days > 0) {
        return $days . ' д. назад';
    } elseif ($hours > 0) {
        return $hours . ' ч. назад';
    } elseif ($days > 0 && $hours > 0) {
        return $days . ' д.' . $hours . ' ч. назад';
    } elseif ($minutes <= 0) {
        print ('Только что');
    } else {
        return $minutes . ' м. назад';
    }
}
/**
 * //Валидация добавления ставки
 * @param $con
 * @param $lot_id
 * @param $user_id
 * @return int
 */
function allowedBet($con, $lot_id, $user_id) {
    $allowed_sql = 'SELECT `id` FROM `bet`
                    WHERE `lot_id` = ?
                    AND `user_id` = ?';
    $stmt = db_get_prepare_stmt($con, $allowed_sql, [$lot_id, $user_id]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    return mysqli_stmt_num_rows($stmt);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>