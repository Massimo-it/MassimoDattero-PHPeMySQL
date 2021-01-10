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
  <h2 class="h2-index">Inserimento di una nuova COSA DA FARE:</h2>
  
  <?php

   /* new TO DO management */
  if ($_POST) {
    $priority = $_POST['pri'];
      if ($priority >= 1 and $priority <= 3) {
        $description1 = $_POST['desc'];
        $description = trim($description1);   /* cancel the spaces */
        $description = filter_var($description, FILTER_SANITIZE_STRING);   /*sanitize */
        if (strlen($description <= 500)) {
          try {
          $query = "INSERT INTO elencotodo (priority, description, utente_id) VALUES (:priority, :description, '$user')";
          $rq = $PDO->prepare($query);
          $rq->bindParam("priority", $priority, PDO::PARAM_INT);
          $rq->bindParam("description", $description, PDO::PARAM_STR);
          $rq->execute();
          } catch(PDOException $e) {
              echo "Errore di inserimento nel DB" . $e->getMessage();
          }
          echo "<h3>Iserimento effettuato </h3>";
        } else {
          echo "<h3>La Descrizione deve essere minore di 500 caratteri!</h3>";
        }
      } else {
        echo "<h3>La Priorità deve essere 1, 2 o 3 </h3>";

      }
    
  }
  ?>
  
  <div class="box-new">
  
    <div class="box-form">
      <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="pri"><b>Priorità (1 = urgente, 2 = medio, 3 = non urgente)</b></label>
        <input type="number" name="pri" required>

        <label for="desc"><b>Descrizione (max 500 caratteri)</b></label>
        <input type="text" name="desc" required>
            
        <button type="submit" class="light-btn">Conferma inserimento</button>
      </form>
      
      <form action="elenco.php" method="get"> 
        <input type="submit" class="dark-btn" value="Ritorna all'elenco" name="comeBack">
      </form>
    </div>
  
  </div>
  
</div>


</body>
</html>