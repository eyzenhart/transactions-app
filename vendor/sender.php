<?php

if ($_SESSION['user']) {
  $get_sender = 'SELECT * FROM `account` WHERE account.id = '.$_SESSION["user"]["id"].'';
  $sender = $pdo->query($get_sender);
  $res = $sender->fetch(PDO::FETCH_ASSOC);
  
  $_SESSION["account"] = [
    "account_id" => $res["account_id"],
    "balance" => $res["balance"]
  ];
}
?>