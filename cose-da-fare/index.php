<?php

require_once './include/default.php';

if ($_POST) {
  if ($_POST['uname'] != '') {
    $userManagement->login($_POST['uname'], $_POST['psw']);
  } elseif ($_POST['newUser'] == 'Mi voglio iscrivere') {
    header('location: registrati.php');
  } else {
    header('location: index.php');
  }
}

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
  
  
  <h1 class="h1-index">LE MIE COSE DA FARE</h1>
  
  <br>
  <div class="box">
    <div>
      <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      
        <label for="uname"><b>Username</b></label>
        <input type="text" name="uname">

        <label for="psw"><b>Password</b></label>
        <input type="password" name="psw">
            
        <button type="submit" class="light-btn">Login</button>

        <input type="submit" class="dark-btn" value="Mi voglio iscrivere" name="newUser">
      
      </form>
    </div>
    
    <img src="./immagini/checklist.png" alt="checklist">
    
  </div>
  
  
</div>

<footer>
<p>immagini tratte da pixabay.com - sito creato da <a 
href="https://www.linkedin.com/in/massimo-dattero-27a70321/" target="_blank">Massimo Dattero</a></p>
</footer>


</body>
</html>