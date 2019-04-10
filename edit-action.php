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

function updateTask($pdo, $table, $data)
{
    $id = array_keys($data);
    $id = $id[0]." = :".$id[0];
    $data1 = $data;
    unset($data['id']);

    // делаем string ':title, :description, :img' (length=26)
    $string = ":" . implode(", :", array_keys($data));
    $string1 = ":" . implode(", :", array_keys($data1));

    // делаем массив с placeholders
    //  0 => string ':title' (length=6)
    //  1 => string ':description' (length=12)
    //  2 => string ':img' (length=4)
    $string = explode(', ', $string);
    $string1 = explode(', ', $string1);

   //Делаем массив ключей
    $keys = array_keys($data);
    $keys1 = array_keys($data1);

    //Склеиваем ключи и placeholders
    $stringcombine = array_combine($keys, $string);
    $stringcombine1 = array_combine($keys1, $string1);
    $stringcombine1['img'] = $data1['img'];
   foreach ($stringcombine as $key => $str) {
       $stri[] = $key. " = " . $str;
       }
        $p = implode(", ", $stri);
//   echo $p;
//   var_dump($stringcombine1);

    $sql = "UPDATE {$table} SET {$p} WHERE {$id}";
    echo $sql;
    $statement = $pdo->prepare($sql);
    $result = $statement->execute($stringcombine1);
    return $result;
}
updateTask($pdo, $table, $data);

header('Location: list.php');