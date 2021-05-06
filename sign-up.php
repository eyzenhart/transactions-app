<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link rel="stylesheet" href="css/style.css">

  <?php 
    session_start();

    if (@$_SESSION['user']) {
      header('Location: main.php');
    }
  ?>

</head>
<body>
  <div class="login__container">
    <h1 class="login__title">Регистрация</h1>
    <form class="login__form" action="vendor/add_user.php" method="POST">
      <ul class="form__content">
        <li class="form__content__item">
          <label for="user_name">Имя:</label>
          <input type="text" name="user_name" id="user_name" pattern="^[a-z,A-Z,а-я,А-Я]{1,20}$" required>
        </li>
        <li class="form__content__item">
          <label for="user_surname">Фамилия:</label>
          <input type="text" name="user_surname" id="user_surname" pattern="^[a-z,A-Z,а-я,А-Я]{1,20}$" required>
        </li>
        <li class="form__content__item">
          <label for="user_login">Логин:</label>
          <input type="text" name="user_login" id="user_login" pattern="^[a-z,A-Z]{1,20}$" required>
        </li>
        <li class="form__content__item">
          <label for="user_pass">Пароль:</label>
          <input type="password" name="user_password" minlength="6" id="user_password" required>
        </li>
        <li class="form__content__item">
          <label for="user_account">Номер счета: <p class="form_flag">*</p></label>
          <input type="text" name="user_account" id="user_account" pattern="[0-9]{16}$" maxlength="16" required>
        </li>
      </ul>
      <p class="form__flag__description">* поле должно содержать 16 символов (только цифры)</p>
      <button class="registration__button" type="submit">Зарегистрироваться</button>
      <p class="registration__alternative">У вас есть аккаунт? <a href="sign-in.php">авторизируйтесь</a></p>
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