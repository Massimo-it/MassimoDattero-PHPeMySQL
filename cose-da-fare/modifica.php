<?php
$logged = "logged";
require './include/default.php';

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
  <h2 class="h2-index">COSA DA FARE da modificare</h2>
  
  <table class="center">
  <tr>
    <th class="priority">PRIORITA'</th>
    <th class="description">DESCRIZIONE</th>
  </tr>

  <?php 
    /* query to get the TO DO to be modified and creation of the table */
  $xx = $_GET['modify'];
  $query = "SELECT * FROM elencotodo WHERE ID = '$xx'";
  $rq = $PDO->prepare($query);
  $rq->execute();
  while ($record = $rq->fetch(PDO::FETCH_ASSOC)) {
    if ($record['priority'] == 1) {
          $color = "<td class='round' style='background-color:#ffb3b3'>";
      } elseif ($record['priority'] == 2) {
          $color = "<td class='round' style='background-color:#ffffcc'>";
      } else {
          $color =  "<td class='round' style='background-color:#b3ffb3'>";
      }      
    echo "<tr>";
    echo $color . $record['priority'] . "</td>";
    echo "<td class='desc'>" . $record['description'] . "</td>";
    echo "</tr>";
  }
  
  ?>
  
  </table>
  
  <h2 class="h2-index">Qui inserisci i nuovi dati per questa COSA DA FARE:</h3>
  <br>
  
  <?php
  require './include/conn.php';
    /* insert od the to do modified - sanitize and query */
  if ($_POST) {
    $priority = $_POST['pri'];
    if ($priority >= 1 and $priority <= 3) {
      $description1 = $_POST['desc'];
      $description = trim($description1);
      $description = filter_var($description, FILTER_SANITIZE_STRING);
      
      if (strlen($description) <= 500) {
        try {
        $query = "UPDATE elencotodo SET priority=:priority, description=:description WHERE ID = '$xx'";
        $rq = $PDO->prepare($query);
        $rq->bindParam(":priority", $priority, PDO::PARAM_INT);
        $rq->bindParam(":description", $description, PDO::PARAM_STR);
        $rq->execute();
        } catch(PDOException $e) {
            echo "Errore di inserimento nel DB" . $e->getMessage();
        }
        header('location: elenco.php');
      } else {
        echo "<h3>La Descrizione deve essere minore di 500 caratteri!</h3>";
      }
    } else {
      echo "<h3>La Priorità deve essere 1, 2 o 3 </h3>";
    }
  }
  ?>
  
  <div class="box-new2">
    <div class="box-form">
      <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      
        <label for="pri"><b>Priorità (1 = urgente, 2 = medio, 3 = non urgente)</b></label>
        <input type="number" name="pri" required>

        <label for="desc"><b>Descrizione (max 500 caratteri)</b></label>
        <input type="text" name="desc" required>
            
        <button type="submit" class="light-btn">Conferma modifiche</button>
        
      </form>
    
    
    
      <form action="elenco.php" method="get"> 
          <input type="submit" class="dark-btn" value="Ritorna all'elenco" name="comeBack">
      </form>
    </div>
  </div>
  
</div>
</body>
</html>