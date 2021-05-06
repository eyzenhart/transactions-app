<?php
  session_start();
  require 'configDB.php';

  $user_name = $_POST['user_name'];
  $user_surname = $_POST['user_surname'];
  $user_login = $_POST['user_login'];
  $user_password = md5($_POST['user_password']);
  $user_account = $_POST['user_account'];
  $user_id = random_int(1, 10000);
  $user_balance = random_int(50, 20000);

  if (strlen($user_account) == 16) {

    $clients = "SELECT COUNT(*) FROM clients WHERE login = '$user_login'";
    $clients_query = $pdo->prepare($clients);
    $clients_query->execute();

    if ($clients_query = $pdo->query($clients)) {
      if (($check = $clients_query->fetchColumn()) > 0) {

        $_SESSION['message'] = 'Пользователь с таким логином уже существует';
        header('Location: ../sign-up.php');
      
      } else {

        $account = 'INSERT INTO account(id, account_id, balance) VALUES(:user_id, :user_account, :user_balance)';
        $account_query = $pdo->prepare($account);
        $account_query->execute(['user_id' => $user_id, 'user_account' => $user_account, 'user_balance' => $user_balance]);
    
        $client = 'INSERT INTO clients(id, name, surname, login, password) VALUES(:user_id, :user_name, :user_surname, :user_login, :user_password)';
        $query = $pdo->prepare($client);
        $query->execute(['user_id' => $user_id, 'user_name' => $user_name, 'user_surname' => $user_surname, 'user_login' => $user_login, 'user_password' => $user_password]);


        $_SESSION['message'] = 'Регистрация прошла успешно';
        header('Location: ../sign-in.php');
      }
    } 
  }
?> 