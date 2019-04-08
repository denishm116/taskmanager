<?php
session_start();



$id = ($_GET['id']);

require "db_connect.php";

//Выборка задач из списка
function taskList($pdo, $id)
{
    $sql = "SELECT * FROM tasks WHERE id = '$id'";
    $statement = $pdo->prepare($sql);
    $array = $statement->execute();
    $array = $statement->fetch(PDO::FETCH_ASSOC);
    return $array;
}

$array = taskList($pdo, $id);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" method="post" action="/edit-action.php" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $array['id']; ?>">
        <img class="mb-4" src="/assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Изменить замись № <?php echo $array['id']; ?></h1>
        <label for="inputEmail" class="sr-only">Название</label>
        <input type="text" name="title" id="inputEmail" class="form-control" placeholder="Название" required value="<?php echo $array['title']; ?>">
        <label for="inputEmail" class="sr-only">Описание</label>
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Описание"><?php echo $array['description']; ?></textarea>
        <input type="file" name="image">
        <img src="/uploads/<?php echo $array['img']; ?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
