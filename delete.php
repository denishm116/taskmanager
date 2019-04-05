<?php
session_start();

$id = ($_GET['id']);

require "db_connect.php";
//Удаление данных по id
$pdo->exec("DELETE FROM tasks WHERE id = '$id'");

header('Location: /list.php');