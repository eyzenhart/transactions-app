<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main page</title>
  <link rel="stylesheet" href="css/style.css">


  <?php
    session_start();
    require 'vendor/configDB.php';
    require 'vendor/sender.php';

    if (!$_SESSION['user']) {
      header('Location: sign-in.php');
    }
  ?>

</head>
<body class="main__body">
  <div class="body__wrapper">
    <header class="main__header">
      <h1 class="header__title">Здравствуйте, <?= $_SESSION['user']['name']?></h1>
      <ul class="header__content">
        <li>
          <p class="balance__value">
          
          <?php 
            $get_balance = 'SELECT account.balance FROM `account` INNER JOIN `clients` ON account.id = clients.id WHERE clients.id = '.$_SESSION["user"]["id"].'';
            $balance_query = $pdo->query($get_balance);
            $balance = $balance_query->fetch(PDO::FETCH_ASSOC);
            
            echo "Ваш баланс: ".$balance['balance']." руб."; 
          ?>

          </p>
        </li>
        <li class="header__content__item">
          <a href="vendor/logout.php">Выход</a>
        </li>
      </ul>
    </header>
    <main class="main__page">
      <div>
        <form class="main__form" action="vendor/transactions.php" method="POST">
          <ul class="main__form__content">
            <li class="main__form__item">
              <label for="amount">Введите сумму:</label>
              <input type="number" name="amount" id="amount" min="1" max="10000" required>
            </li>
            <li class="main__form__item">
              <label for="receiver_account">Введите номер счета получателя: <p class="main__form_flag">*</p></label>
              <input type="text" name="receiver_account" id="receiver_account" pattern="[0-9]{16}$" maxlength="16" required> 
            </li>
          </ul>
          <p class="main__form__flag__description">* поле должно содержать 16 символов (только цифры)</p>

          <button class="main__form__button" type="submit">Совершить перевод</button>

          <?php 
            if(@$_SESSION['transaction_msg']) {
              echo '<p class="message">'.$_SESSION['transaction_msg'].'</p>';
            };
            unset($_SESSION['transaction_msg']);
          ?>

        </form>
      </div>
      
      <div class="history__container">
        <p class="history__title">История операций</p>
        <ul class="history__content">

          <?php 
            $user_transactions = 'SELECT * FROM `transaction` WHERE transaction.acc_from = '.$_SESSION["account"]["account_id"].' OR transaction.acc_to = '.$_SESSION["account"]["account_id"].'';
            $user_tr_query = $pdo->query($user_transactions);
            $result = $user_tr_query->fetchAll();

            if (!$result) {
              echo '<p class="history_empty">Ваша история переводов пока пуста</p>';
            }
            foreach ($result as $row) {

              if ($row["acc_from"] == $_SESSION["account"]["account_id"]) {
                $receiver = 'SELECT account.id FROM `account` WHERE account.account_id = '.$row["acc_to"].'';
                $rec = $pdo->query($receiver);
                $rec_final = $rec->fetch(PDO::FETCH_ASSOC);

                foreach ($rec_final as $final) {
                  $receiver_info = 'SELECT clients.name, clients.surname FROM `clients` WHERE clients.id = '.$final.'';
                  $res = $pdo->query($receiver_info);
                  $res_final = $res->fetch(PDO::FETCH_ASSOC);
                }

                $_SESSION["res"] = [
                  "name" => $res_final["name"],
                  "surname" => $res_final["surname"]
                ];

                echo '<li class="history__content__item">Исходящий перевод на сумму '.$row["value"].' руб. пользователю '.$_SESSION["res"]["name"].' '.$_SESSION["res"]["surname"].'</li>';
              
              } else {

                $sender = 'SELECT account.id FROM `account` WHERE account.account_id = '.$row["acc_from"].'';
                $rec = $pdo->query($receiver);
                $rec_final = $rec->fetch(PDO::FETCH_ASSOC);

                foreach ($rec_final as $final) {
                  $receiver_info = 'SELECT clients.name, clients.surname FROM `clients` WHERE clients.id = '.$final.'';
                  $res = $pdo->query($receiver_info);
                  $ress_final = $res->fetch(PDO::FETCH_ASSOC);
                }

                $_SESSION["sender"] = [
                  "name" => $ress_final["name"],
                  "surname" => $ress_final["surname"]
                ];

                echo '<li class="history__content__item">Входящий перевод на сумму '.$row["value"].' руб. от пользователя '.$_SESSION["sender"]["name"].' '.$_SESSION["sender"]["surname"].'</li>';
              }
            }
          ?>

        </ul>
      </div>
    </main>
  </div>
</body>
</html>
