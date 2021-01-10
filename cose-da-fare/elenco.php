<?php
$logged = "logged";
require_once './include/default.php';

if ($_POST) {
  if ($_POST['logout'] == 'Logout') {
    $userManagement->logout();
  } elseif ($_POST['passwordChange'] == 'Profilo') {
    header('location: profilo.php');
  } else {
    header('location: elenco.php');
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
  
  <h1 class="h1-index">Benvenuto <em><?php echo $userName; ?></em> ecco il tuo elenco di <br>COSE DA FARE</h1>
  <br>
  <p class="list">LEGENDA: &#128565 = Urgente, &#128528 = Medio, &#128526 = Non Urgente</p>
  
<!-- query to get the list from the DB and create the table -->

<table class="center">
  <tr>
    <th class="priority">PRIORITA'</th>
    <th class="description">DESCRIZIONE</th>
    <th class="change">MODIFICA</th>
    <th class="cancel">ELIMINA</th>
  </tr>
  
  <?php 
  

  try {
    $query = "SELECT utentiloggatitodo.id_logged, elencotodo.ID, elencotodo.priority, elencotodo.description, elencotodo.utente_id FROM
    elencotodo INNER JOIN utentiloggatitodo ON elencotodo.utente_id = utentiloggatitodo.id_logged ORDER BY priority, description ASC";
    $rq = $PDO->prepare($query);
    $rq->execute();
  } catch (PDOException $e) {
          echo "Errore di estrazione dati dal DB" . $e->getMessage();
  }
  if($rq->rowCount() == 0 ) {
    echo "<h3>non hai ancora COSE DA FARE in elenco.</h3>";
      } else {
  
      while ($record = $rq->fetch(PDO::FETCH_ASSOC)) {
        $xx = $record['ID'];
        if ($record['priority'] == 1) {
          $color = "<td class='round' style='background-color:#ffb3b3'> &#128565 ";
      } elseif ($record['priority'] == 2) {
          $color = "<td class='round' style='background-color:#ffffcc'> &#128528 ";
      } else {
          $color =  "<td class='round' style='background-color:#b3ffb3'> &#128526 ";
      }      
        echo "<tr>";
        echo $color . "</td>";
        echo "<td class='desc'>" . $record['description'] . "</td>";
        echo "<td class='link_modify'><a href='modifica.php?modify={$xx}'> &#9989 </a></td>";
        echo "<td class='link_cancel'><a href='elimina.php?delete={$xx}'> &#10060 </a></td>";
        echo "</tr>";
        
        }
      } 
  
  ?>
</table>

<div class="buttons">
  <form action="nuovo.php" method="get"> 
      <input type="submit" class="list-btn" value="Nuova cosa da fare" name="new-todo">
    </form>
    
  <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post"> 
    <input type="submit" class="list-btn" value="Logout" name="logout">
  </form>

  <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post"> 
    <input type="submit" class="list-btn" value="Profilo" name="passwordChange">
  </form>
</div>
  
</body>
</html>