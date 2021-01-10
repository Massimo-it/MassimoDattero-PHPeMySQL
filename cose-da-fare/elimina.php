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
  <h2 class="h2-index">Sei sicuro di voler eliminare la seguente COSA DA FARE?</h2>
  <br>
  
  <div class="box-new3">
    <div>
  
      <table class="center">
      <tr>
        <th class="priority">PRIORITA'</th>
        <th class="description">DESCRIZIONE</th>
      </tr>

      <?php 
        /* query to get the TO DO to be eliminated and creation of the table */
      $xx = $_GET['delete'];
      $query = "SELECT * FROM elencotodo WHERE ID = $xx";
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
      
      <div class="buttons">
        
        <!-- button cancel -->
        <?php
        
          /* the elimination of the TO DO will be done by cancella.php */
        echo "
        <button class='list-btn canc-btn2'>
        <a class='white' href='cancella.php?delete={$xx}'>Elimina</a>
        </button>";
        ?>
        
        <!-- button come back -->
        <form action="elenco.php" method="get"> 
          <input type="submit" class="list-btn canc-btn1" value="Ritorna all'elenco" name="comeBack">
        </form>
    
      </div>
      
    </div>
  </div>
  
 
</div>
</body>
</html>