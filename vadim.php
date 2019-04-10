<?php
/**
 * Created by PhpStorm.
 * User: ДенисПК
 * Date: 09.04.2019
 * Time: 18:04
 */
function insertQuery($table, $values) {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=taskmanager_db", root, toor);
    //Извлекаем ключи передаваемого массива значений (будут использоваться как название столбцов БД)
    $keys = array_keys($values);
    //Преобразуем ключи в вид placeholders для PDO
    $string = ':'.implode(', :', $keys);
    //Сохраняем массив с placeholders
    $placeholders = explode(", ", $string);
    //объединяем массив с placeholders и значениями для передачи в execute
    $values = array_combine($placeholders, $values);
    //Формируем запрос с нашими данными
    $sql  = "INSERT INTO $table";
    $sql .= " (".implode(", ", $keys) .")";
    $sql .= " VALUES (".$string.")";
    $statement = $pdo->prepare($sql);
    $result=$statement->execute($values);
    return $result;
}

function getOneValue ($pdo, $table, $field, $value)
{
    $sql = "SELECT COUNT(*) FROM {$table} WHERE {$field} = :value";
    $stmt = $pdo->prepare($sql);
    $params = [':value' => $value];
    $rows = $stmt->execute($params);
    $row = $stmt->fetch();
    return $row[0];
}

function checkingRegisteredUsers ($pdo, $name, $email)
{
    $count_users = getOneValue($pdo, 'users', 'username', $name);
    $count_emails = getOneValue($pdo, 'users', 'email', $email);

    if ($count_users > 0) {
        $error = "Пользователь с таким именем уже существует";
        require "errors.php";
        exit;
    } elseif ($count_emails > 0) {
        $error = "Пользователь с таким email уже существует";
        require "errors.php";
        exit;
    }
}