<?php
$logged = "logged";
require './include/default.php';

if ($_POST) {
  } elseif ($_POST['cancelUser1'] == 'Elimina Profilo') {
      $token = $_POST['token'];
  } elseif ($_SESSION['csrf'] != $token) {   // against csrf attack
      header('location: index.php');
      exit;
  }
  
if ($_POST) {    
  if ($_POST['cancelUser1'] == "Elimina") {
      $userManagement->cancelUser($user);
  }
}

if ($userManagement->loggedUser() == false) {
  header('location: index.php');
  exit;
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

<h1 class="h1-index">COSE DA FARE di <em><?php echo $userName; ?></em></h1>
<br>
<h3>Sei sicuro di voler eliminare il tuo profilo?</h3>



  <div class="form-prof3">

    <form action="elenco.php" method="get"> 
      <input type="submit" class="pro-btn" value="Ritorna all'elenco" name="comeBack">
    </form>
    
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post"> 
      <input type="submit" class="pro-btn" value="Elimina" name="cancelUser1">
    </form>
      
  </div>
  
</div>


</div>
</body>
</html>