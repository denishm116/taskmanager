<?php
session_start();

echo ($_GET['id']);

$id = ($_GET['id']);

$pdo = new PDO('mysql:host=localhost;dbname=taskmgr', 'root', '');

//Выборка из БД для провелки логина
$sql = "SELECT * FROM tasks WHERE id = '$id'";
$statement = $pdo->prepare($sql);
$array = $statement->execute();
$array = $statement->fetchAll(PDO::FETCH_ASSOC);
//echo $array['id'];
//var_dump($array);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
  <?php foreach ($array as $arr) { ?>
    <div class="form-wrapper text-center">

      <img src="uploads/<?php echo $arr['img']; ?>" alt="" width="400">
      <h2><?php echo  $arr['title']; ?></h2>
      <p>
          <?php echo  $arr['description']; ?>
      </p>
    </div>
  <?php } ?>
  </body>
</html>
