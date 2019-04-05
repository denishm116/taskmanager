<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


    //Проверка полей формы на пустоту
    if (empty($name) || empty($email) || empty($password)) {
        header('Refresh: 3; url=register-form.php');
        echo "Заполните все поля формы";
    exit;
    }

    //Шифрование праоля
    $pass = md5($password);

    // Соединение с БД
    require "db_connect.php";

    //Выборка из БД для провелки логина
    $sql1 = "SELECT * FROM users";
    $statement1 = $pdo->prepare($sql1);
    $array1 = $statement1->execute();
    $array1 = $statement1->fetchAll(PDO::FETCH_ASSOC);

    //Переборка массива для проверки на наличие пользователя с таким именем и емаил
    foreach ($array1 as $arr) {
        if ($arr['username'] == $name) {
            header('Refresh: 3; url=register-form.php');
            echo "Пользователь с таким именем уже существует";
            exit;
        }
        elseif ($arr['email'] == $email) {
            header('Refresh: 3; url=register-form.php');
            echo "Пользователь с таким E-mail уже существует";
            exit;
        }
    }

    //Запись в БД
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":username", $name);
    $statement->bindValue(":email", $email);
    $statement->bindValue(":password", $pass);
    $statement->execute();

//Редирект на авторизацию
header('Location: login-form.php');


