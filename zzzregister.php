<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//Соединение с БД
require "db_connect.php";

    //функция Проверка полей формы на пустоту
    function checkingForm($name, $email, $password)
    {
        if (empty($name) || empty($email) || empty($password))
        {
            header('Refresh: 3; url=register-form.php');
            $error = "Заполните все поля формы";
            require "errors.php";
            exit;
        }
    }

    //вызов функция Проверка полей формы на пустоту
    checkingForm($name, $email, $password);

    //Шифрование праоля
    $pass = md5($password);

    //Выборка из БД для провелки логина и емаила на существующие
    function checkingRegisteredUsers ($pdo, $name, $email)
    {
    $sql1 = "SELECT * FROM users WHERE username = '$name'";
    $sql2 = "SELECT * FROM users WHERE email = '$email'";
    $statement1 = $pdo->prepare($sql1);
    $statement2 = $pdo->prepare($sql2);
    $array1 = $statement1->execute();
    $array1 = $statement1->fetch(PDO::FETCH_ASSOC);
    $array2 = $statement2->execute();
    $array2 = $statement2->fetch(PDO::FETCH_ASSOC);

        if ($array1['username'] == $name) {
            $error = "Пользователь с таким именем уже существует";
            require "errors.php";
            exit;
        } elseif ($array2['email'] == $email) {
            $error = "Пользователь с таким email уже существует";
            require "errors.php";
            exit;
        }
    }

    //Вызоа функции Выборка из БД для провелки логина и емаила на существующие
    checkingRegisteredUsers($pdo, $name, $email);


    //Функция Запись в БД
    function insertIntoDb ($pdo, $name, $email, $pass) {
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $statement = $pdo->prepare($sql);

    $statement->bindValue(":username", $name);

    $statement->bindValue(":email", $email);
    $statement->bindValue(":password", $pass);

   $statement->execute();

    }

    //Вызов функции Записи в БД
    insertIntoDb ($pdo, $name, $email, $pass);

    //Редирект на авторизацию
    header('Location: login-form.php');









//Переборка массива для проверки на наличие пользователя с таким именем и емаил
//    foreach ($array1 as $arr) {
//        if ($arr['username'] == $name) {
//            header('Refresh: 3; url=register-form.php');
//            echo "Пользователь с таким именем уже существует";
//            exit;
//        }
//        elseif ($arr['email'] == $email) {
//            header('Refresh: 3; url=register-form.php');
//            echo "Пользователь с таким E-mail уже существует";
//            exit;
//        }
//    }
