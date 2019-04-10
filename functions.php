<?php

//Проверка на совпадение имени и емаила пользователся
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

//Запись в БД
function insertIntoDb($pdo, $table, $data) {
    //Извлекаем ключи передаваемого массива значений (будут использоваться как название столбцов БД)
    $keys = implode(', ', array_keys($data));
    //Преобразуем ключи в вид placeholders для PDO
    $string = ":" . implode(", :", array_keys($data));
    //Сохраняем массив с placeholders
    $placeholders = explode(", ", $string);
    //объединяем массив с placeholders и значениями для передачи в execute
    $values = array_combine($placeholders, $data);
    //Формируем SQL запрос
    $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$string})";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute($values);
    return $result;
}


//Имя картинки
function uploadImage($image)
{
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    if(!($extension == '')) {
        $filename = uniqid() . "." . $extension;
        move_uploaded_file($image['tmp_name'], "uploads/" . $filename);
    } else {
        $filename = "noimage.jpg";
    }
    return $filename;
}

//Выборка задач из списка для редактирования (по нажатию на кнопку "редактировать")
function taskList($pdo, $id)
{
    $sql = "SELECT * FROM tasks WHERE id = '$id'";
    $statement = $pdo->prepare($sql);
    $array = $statement->execute();
    $array = $statement->fetch();
    return $array;
}



//Функция чекает изменение имени файла при редактировании задачи.
function fileCheck ($pdo, $fn, $id)
{
    if (!$fn) {
        $sql = "SELECT * FROM tasks WHERE id = '$id'";
        $statement = $pdo->prepare($sql);
        $array = $statement->execute();
        $array = $statement->fetch();
        $filename = $array['img'];
    } else {

        $filename = uploadImage($_FILES['image']);
    }
    return $filename;
}

