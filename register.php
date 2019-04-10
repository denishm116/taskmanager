<?php

$data = $_POST;
$table = "users";

function checkFormEmpty ($data)
{
    foreach ($data as $key => $dat) {
    if (!$dat) {
        $error = "Заполните " . $key;
        require 'errors.php';
    }
    }
}
checkFormEmpty($data);

$data['password'] = md5($data['password']);

require "db_connect.php";

require "functions.php";

//Проверка логина и емаила на существующие
checkingRegisteredUsers($pdo, $name, $email);

//Запись БД (сохранение данных нового пользователя)
insertIntoDb($pdo, $table, $data);

header('Location: login-form.php');

