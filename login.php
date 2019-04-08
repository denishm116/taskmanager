<?php
session_start();

$email = ($_POST['email']);
$password = ($_POST['password']);

$pass = md5($password);

//Подключаемся к БД
require "db_connect.php";

//Выборка из БД для провелки логина
function allUsers($pdo)
{
    $sql = "SELECT * FROM users";
    $statement = $pdo->prepare($sql);
    $array = $statement->execute();
    $array = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $array;
}

$allusers = allUsers($pdo);


//Проверка имени и  парлоя и запись в сессию переменных
function login($allusers, $email, $pass)
{
    foreach ($allusers as $arr) {
        if ($arr['email'] == $email) {
            if ($arr['password'] == $pass) {
                $_SESSION['email'] = $email;
                $_SESSION['userid'] = $arr['id'];
                $_SESSION['username'] = $arr['username'];
            require "list.php";
            }
        }

    }
    var_dump(login($allusers));
}

//Вызов функции проверки имени и  парлоя и запись в сессию переменных
login($allusers, $email, $pass);

//require "list.php";
//var_dump($pass);