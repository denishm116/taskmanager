<?php
session_start();

$data = $_POST;
$table = "tasks";
$userid = ($_SESSION['userid']);

//Подключаемся к БД
require "db_connect.php";

//Функция для создания уникального имени файла (дословно скопированная с видео про MVC на ютубе), с добавленем прверки на то, выбран ли файл.
require "functions.php";

//Создаем имя файла
$filename = uploadImage($_FILES['image']);

//Добавляем в массив ID пользвателя и имя картинки
$data['userid'] = $userid;
$data['img'] = $filename;

//Запись в БД новой задачи
insertIntoDb($pdo, $table, $data);

//Перенаправляем на список задач
header('Location: list.php');

