<?php
session_start();

$title = ($_POST['title']);
$short_description = ($_POST['short_description']);
$description = ($_POST['description']);
$userid = ($_SESSION['userid']);

//Функция для создания уникального имени файла (дословно скопированная с видео про MVC на ютубе), с добавленем прверки на то, выбран ли файл.
require "image-name.php";

    $filename = uploadImage($_FILES['image']);

//Записываем данные в БД
$pdo = new PDO('mysql:host=localhost;dbname=taskmgr', 'root', '');
$sql = "INSERT INTO tasks (userid, title, short_description, description, img) VALUES (:userid, :title, :short_description, :description, :img)";
$statement = $pdo->prepare($sql);
$statement->bindValue(":userid", $userid);
$statement->bindValue(":title", $title);
$statement->bindValue(":short_description", $short_description);
$statement->bindValue(":description", $description);
$statement->bindValue(":img", $filename);
$statement->execute();

//Перенаправляем на список задач
header('Location: list.php');

