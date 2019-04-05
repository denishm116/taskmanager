<?php
session_start();

$id = ($_POST['id']);
$title = ($_POST['title']);
$description = ($_POST['description']);

//подключаем функцию для создания имени файла
require "image-name.php";
$filename = uploadImage($_FILES['image']);

require "db_connect.php";

//Строка для изменения записей в таблице задач
$sql = "UPDATE tasks SET title = :title, description = :description, img = :img WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam(":id", $id);
$statement->bindParam(":title", $title);
$statement->bindParam(":description", $description);
$statement->bindParam(":img", $filename);
$statement->execute();

header('Location: list.php');