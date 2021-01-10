<?php
$logged = "logged";
require './include/default.php';

if ($userManagement->loggedUser() == false) {
  header('location: index.php');
  exit;
}
// against csrf attack
$_SESSION['csrf'] = bin2hex(random_bytes(10));

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
  
  <h1 class="h1-index">COSE DA FARE di <em><?php echo $userName; ?></em></h1>
  <br>
  <h2 class="h2-index">Modulo Cambio Password di <em><?php echo $userName; ?></em><h2>
  <br>
  
  <?php 
    /* change of the password */
    if ($_POST) {
      if ($_POST['changePsw'] == "Conferma Cambio Password") {
        $_POST['user'] = $user;
        $userManagement->changePassword($_POST['user'], $_POST['psw'], $_POST['psw2']);
      } else {
        header('location: profilo.php');
      }
    }
   
    ?>
    
  <div class="box box-new4">
  
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" class="form-prof">

      <label for="psw"><b>Nuova Password (da 3 a 20 caratteri - [a-z, A-Z, 0-9, +=!@#$%)</b></label>
      <input type="password" name="psw">
      
      <label for="psw2"><b>Conferma della Nuova Password</b></label>
      <input type="password" name="psw2">
          
      <input class="dark-btn" type="submit" name="changePsw" value="Conferma Cambio Password">

    
    </form>
    
    <div class="form-prof2">
      <form action="elenco.php" method="get"> 
        <input type="submit" class="pro-btn" value="Ritorna all'elenco" name="comeBack">
      </form>
      
      <form action="profiloElimina.php" method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION['csrf'] ?>">
        <input type="submit" class="pro-btn" value="Elimina Profilo" name="cancelUser1">
      </form>
    </div>
  
  </div>
  
</div>
  

</body>
</html>