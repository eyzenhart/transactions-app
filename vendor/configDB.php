<?php 

$db_server = "localhost";
$db_name = "simple_database";
$db_user = "root";
$db_password = "rootroot";

$dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8"; 

$opt = array(
  PDO::ATTR_ERRMODE  => PDO::ERRMODE_SILENT,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

try {
  $pdo = new PDO($dsn, $db_user, $db_password, $opt); 
} catch (PDOException $e) {
  echo 'Подключение не удалось: ' . $e->getMessage();
}

?>