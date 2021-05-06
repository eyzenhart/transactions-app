<?php 
  session_start();
  require 'configDB.php';

  $user_login = $_POST['user_login'];
  $user_password = md5($_POST['user_password']);

  $users_check = "SELECT COUNT(*) FROM clients WHERE login = '$user_login' AND password = '$user_password'";
  $query = $pdo->prepare($users_check);
  $query->execute();

  if($query = $pdo->query($users_check)) {
    if (($user = $query->fetchColumn()) > 0) {

      $users_get = "SELECT * FROM clients WHERE login = '$user_login' AND password = '$user_password'";
      $res = $pdo->query($users_get);
      $user = $res->fetch(PDO::FETCH_ASSOC);

      $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'surname' => $user['surname'],
        'login' => $user['login'],
      ];

      header('Location: ../main.php');

    } else {
      $_SESSION['message'] = 'Пользователь не найден';
      header('Location: ../sign-in.php');
    }
  }


?>