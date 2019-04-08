<?php
session_start();

$id = ($_POST['id']);
$title = ($_POST['title']);
$description = ($_POST['description']);

//Подключаемся к БД
require "db_connect.php";

//подключаем функцию для создания имени файла
require "image-name.php";

$filename = uploadImage($_FILES['image']);

//Строка для изменения записей в таблице задач

function updateTask($pdo, $id, $title, $description, $filename)
{
    $sql = "UPDATE tasks SET title = :title, description = :description, img = :img WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":id", $id);
    $statement->bindParam(":title", $title);
    $statement->bindParam(":description", $description);
    $statement->bindParam(":img", $filename);
    $statement->execute();
}
updateTask($pdo, $id, $title, $description, $filename);
header('Location: list.php');