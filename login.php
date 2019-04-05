<?php
session_start();

$email = ($_POST['email']);
$password = ($_POST['password']);

$pass = md5($password);

//Подключаемся к БД
$pdo = new PDO('mysql:host=localhost;dbname=taskmgr', 'root', '');

//Выборка из БД для провелки логина
$sql = "SELECT * FROM users";
$statement = $pdo->prepare($sql);
$array = $statement->execute();
$array = $statement->fetchAll(PDO::FETCH_ASSOC);

//var_dump($array);
//Проверяем данные (сравниваем с таблицей емаил и пароль)
foreach ($array as $arr) {
    if ($arr['email'] == $email) {
        if ($arr['password'] == $pass) {
            $_SESSION['email'] = $email;
            $_SESSION['userid'] = $arr['id'];
            $_SESSION['username'] = $arr['username'];
            header('Refresh: 1; url=list.php');
            echo "Добро пожаловать " . $arr['username'];
            //Записываем переменную е-маил в сессию, чтобы использовать ее на странице списка задач.

            exit;
        }
    }
}



header('Location: login-form.php');
//var_dump($pass);