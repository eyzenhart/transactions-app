<?php 
  session_start();

  if (@$_SESSION['user']) {
    header('Location: main.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">


</head>
<body>
  <div class="login__container">
    <h1 class="login__title">Пожалуйста, авторизуйтесь</h1>
    <form class="login__form" action="vendor/auth-check.php" method="POST">
      <ul class="form__content">
        <li class="form__content__item">
          <label for="user_login">Введите ваш логин:</label>
          <input type="text" name="user_login" id="user_login">
        </li>
        <li class="form__content__item">
          <label for="user_pass">Введите пароль:</label>
          <input type="password" name="user_password" id="user_password">
        </li>
      </ul>
      <button class="login__button" type="submit">Войти</button>
      <p class="login__alternative">... или <a href="sign-up.php">зарегистрируйтесь</a></p>
        <?php 
          if(@$_SESSION['message']) {
            echo '<p class="msg_warning">'.$_SESSION['message'].'</p>';
          };
          unset($_SESSION['message']);
        ?>

    </form>
  </div>
</body>
</html>