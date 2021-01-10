<?php

//connection to the DB for the project 'Progetto-to-do'

$username = "root";
$password = "";

$dsn="mysql:host=localhost;dbname=progettotodo;charset-utf8";

try {
  $PDO = new PDO($dsn, $username, $password);
  $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {         
  echo "Connessione fallita: " . $e->getMessage();
}
?>