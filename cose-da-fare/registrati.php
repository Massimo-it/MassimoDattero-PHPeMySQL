<?php

require_once './include/default.php';

?>

<!DOCTYPE html>
<html lang="it-it">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="style-to-do.css">
<title>Progetto TO DO</title>
</head>

<body>

<div class="container">
  
  <h1 class="h1-reg">elenco COSE DA FARE</h1>
  <br>
  <h2 class="h2-index">Modulo di Iscrizione<h2>
  <br>
  
  <?php
    if ($_POST) {
    $userManagement->newUser($_POST['uname'], $_POST['psw'], $_POST['psw2']);
    }
    
  ?>
  
  <div class="box-new5">
    <div class="inside">
  
      <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      
        <label for="uname" class="label-reg"><b>Username (da 3 a 20 caratteri alfanumerici)</b></label>
        <input type="text" name="uname">

        <label for="psw" class="label-reg"><b>Password (da 3 a 20 caratteri - [a-z, A-Z, 0-9, +=!@#$%)</b></label>
        <input type="password" name="psw">
        
        <label for="psw2" class="label-reg"><b>Conferma della Password</b></label>
        <input type="password" name="psw2">
            
        <button class="light-btn" type="submit">Conferma registrazione</button>
      
      </form>
      
      <form action="index.php" method="get"> 
        <input type="submit" class="dark-btn" value="Ritorna al login" name="comeBack">
      </form>
    
    </div> 
  </div>
  
</div>
  

</body>
</html>