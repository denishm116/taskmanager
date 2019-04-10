<?php
session_start();
$table = "tasks";
$fn = $_FILES['image']['name'];
$data = $_POST;

//Подключаемся к БД
require "db_connect.php";
require "functions.php";

//Функция чекает изменение имени файла при редактировании задачи.
$filename = fileCheck($pdo, $fn, $_POST['id']);
$data['img'] = $filename;

//Строка для изменения записей в таблице задач

updateTask($pdo, $table, $data);

header('Location: list.php');