<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


    //Проверка полей формы на пустоту

    if (empty($name) || empty($email) || empty($password)) {
    echo "Заполните форму";
    die;
    }

    //Шифрование праоля

    $pass = md5($password);

    // Соединение с БД

    $pdo = new PDO('mysql:host=localhost;dbname=taskmgr', 'root', '');

    //Выборка из БД для провелки логина

    $sql1 = "SELECT username FROM users";
    $statement1 = $pdo->prepare($sql1);
    $array1 = $statement1->execute();
    $array1 = $statement1->fetchAll(PDO::FETCH_ASSOC);

    //Переборка массива для проверки на наличие пользователя с таким именем

    foreach ($array1 as $arr) {
        foreach ($arr as $a) {

            //Если такой пользователь существует, сообщение об этом и редирект на форму регистрации

            if ($a == $name) {
                header('Refresh: 3; url=register-form.php');
                echo "Пользователь существует";
                exit;
            }
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


