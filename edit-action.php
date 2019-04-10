<?php
session_start();
$table = "tasks";
$fn = $_FILES['image']['name'];
$data = $_POST;
$id = $data['id'];
//Подключаемся к БД
require "db_connect.php";
require "functions.php";

//Функция чекает изменение имени файла при редактировании задачи.
$filename = fileCheck($pdo, $fn, $_POST['id']);
$data['img'] = $filename;

//Функция для редактирования записей в таблице задач
updateTask($pdo, $table, $data);

header('Location: list.php');