<?php

session_start();
require 'configDB.php';

$receiver_account = $_POST['receiver_account'];
$amount = $_POST['amount'];

$double_check = "SELECT COUNT(*) FROM account WHERE account_id = '$receiver_account'";
$double_query = $pdo->prepare($double_check);
$double_query->execute();

$get_sender = 'SELECT * FROM `account` WHERE account.id = '.$_SESSION["user"]["id"].'';
$sender = $pdo->query($get_sender);
$res = $sender->fetch(PDO::FETCH_ASSOC);

$_SESSION["account"] = [
  "account_id" => $res["account_id"],
  "balance" => $res["balance"]
];


if ($double_query = $pdo->query($double_check)) {
  if (($double = $double_query->fetchColumn()) > 0) {
    if ($_SESSION["account"]["account_id"] != $receiver_account) {
      $pdo->beginTransaction();
      $pdo->exec('UPDATE `account` SET balance = balance - '.$amount.' WHERE account.id = '.$_SESSION["user"]["id"].'');
      $pdo->exec('UPDATE `account` SET balance = balance + '.$amount.' WHERE account.account_id = '.$receiver_account.'');
      $pdo->commit();
  
      $add_transactions = 'INSERT INTO transaction(acc_from, acc_to, value) VALUES('.$_SESSION["account"]["account_id"].', '.$receiver_account.', '.$amount.')';
      $adding_query = $pdo->prepare($add_transactions);
      $adding_query->execute();
  
      $get_receiver = 'SELECT * FROM `account` WHERE account.account_id = '.$receiver_account.'';
  
      $receiver = $pdo->query($get_receiver);
      $receiver_data = $receiver->fetch(PDO::FETCH_ASSOC);
  
      $_SESSION["receiver_user"] = [
        "id" => $receiver_data["id"]
      ];
  
      $receiver_name = 'SELECT clients.name, clients.surname FROM `clients` WHERE clients.id = '.$_SESSION["receiver_user"]["id"].'';
      $receiver_res = $pdo->query($receiver_name);
      $receiver_final = $receiver_res->fetch(PDO::FETCH_ASSOC);
  
  
      $_SESSION['transaction_msg'] = 'Перевод отправлен пользователю '.$receiver_final["name"].' '.$receiver_final["surname"].'';
      header('Location: ../main.php');

  
    } else {
        $_SESSION['transaction_msg'] = 'Вы не можете совершить перевод на свой аккаунт';
        header('Location: ../main.php');
      }

  } else {
      $_SESSION['transaction_msg'] = 'Данный номер аккаунта не существует';
      header('Location: ../main.php');
    } 
}
?>