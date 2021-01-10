<?php

class UserManagement {
  private $PDO;
  
  public function __construct($PDOconn) {
    $this->PDO = $PDOconn;
  }
  
  public function newUser($uname, $psw, $psw2) {   // new user registration
    //sanification of spaces at the top and at the end and sanitize
    $cleanUser = trim($uname);
    $cleanPassword = trim($psw);
    $cleanPassword2 = trim($psw2);
    $cleanUser = filter_var($cleanUser, FILTER_SANITIZE_STRING);
    // check of the username
    if(!(ctype_alnum($cleanUser) && mb_strlen($cleanUser) >= 3 && mb_strlen($cleanUser) <= 20)) {
      echo "<script>alert('Username troppo lunga o troppo corta!');</script>";
      return false;
    }
    if(!(ctype_alnum($cleanPassword) && mb_strlen($cleanPassword) >= 3 && mb_strlen($cleanPassword) <= 20)) {
      echo "<script>alert('Password troppo lunga lunga o troppo corta!');</script>";
      return false;
    }
    // check if the username is not already present into the DB
    try {
      $query = "SELECT * FROM utentitodo WHERE (username = '$cleanUser')";
      $rq = $this->PDO->prepare($query);
      $rq->execute();
        if ($rq->rowCount() > 0) {
          echo "<script>alert('Username già presente!');</script>";
          return false;
        }  
    } catch(PDOExecption $e) {
      echo "Errore di estrazione" . $e->getMessage();
      }
      // check of the password
      if(!preg_match('/^[a-zA-Z0-9\+=\!@#\$%]{3,20}$/', $cleanPassword)) {
        echo "<script>alert('Password non valida!');</script>";
        return false;
      }
      // check if password and repeated password are equal
      if(strcmp($cleanPassword, $cleanPassword2) !== 0 ) {
        echo "<script>alert('Password e conferma password non uguali!');</script>";
        return false;
      }
      // check if user name has been provided
      if(mb_strlen($cleanUser) == 0 ) {
        echo "<script>alert('Username non inserita!');</script>";
        return false;
      }
      // encript the password
      $passwordHash = password_hash($cleanPassword, PASSWORD_DEFAULT);
      // now we can launch the query
      try {
        $query = "INSERT INTO utentitodo (username, password) VALUES (:uname, :password)";
        $rq = $this->PDO->prepare($query);
        $rq->bindParam(":uname", $cleanUser, PDO::PARAM_STR);
        $rq->bindParam(":password", $passwordHash, PDO::PARAM_STR);
        $rq->execute();
        $message = "<h3>Registrazione effettuata</h3>";
        echo $message;
      } catch(PDOException $e) {
          echo "Errore di inserimento nel DB" . $e->getMessage();
      }
      return true;
  }
  
  public function login($username, $password) {   // here we manage the login of the user
    // sanitize
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    // query
    try {
      $query = "SELECT * FROM utentitodo WHERE username = :username";
      $rq = $this->PDO->prepare($query);
      $rq->bindParam(":username", $username, PDO::PARAM_STR);
      $rq->execute();
      $record = $rq->fetch(PDO::FETCH_ASSOC);
      $id = $record['ID'];
      if (strlen($username) > 20) {
        echo "<script>alert('Username troppo lunga!');</script>";
      } elseif ($rq->rowCount() == 0 ) {
        echo "<script>alert('Username errata!');</script>";
      }  elseif
      // check of the password

       (password_verify($password, $record['password'])) {
        
          try {     //before login clean table utentiloggatitodo
            $query = "DELETE FROM utentiloggatitodo WHERE id_logged = '$id'";
            $rq = $this->PDO->prepare($query);
            $rq->execute();
            } catch(PDOException $e) {
                echo "Errore di inserimento nel DB" . $e->getMessage();
            }
            // the password is OK we can activate the session and register the user in utentiloggatitodo
          $sessionid = session_id();
          $userid = $record['ID'];
          $query = "INSERT INTO utentiloggatitodo (sessionid, id_logged) VALUES (:sessionid, :userid)";
          $rq = $this->PDO->prepare($query);
          $rq->bindParam("sessionid", $sessionid, PDO::PARAM_STR);
          $rq->bindParam("userid", $userid, PDO::PARAM_INT);
          $rq->execute();
          header('location: elenco.php');
          exit;        
      } else {           // if we are here the password is not correct
        echo "<script>alert('Password errata!');</script>";
      }
    
      } catch(PDOException $e) {
          echo "Errore dati non validi" . $e->getMessage();
      }
  }
  
  public function logout() {   // we must cancel the user from the table utentiloggatitodo
    try {
      $query = "DELETE FROM utentiloggatitodo WHERE sessionid = :sessionid";
      $rq = $this->PDO->prepare($query);
      $session_id = session_id();
      $rq->bindParam(":sessionid", $session_id, PDO::PARAM_STR);
      $rq->execute();
    } catch(PDOException $e) {
      echo "Errore di logout" . $e->getMessage();
  }
  session_destroy();
  header('location: index.php');
  }
  
  public function loggedUser() {    //check if user is logged
    try {
      $query = "SELECT * FROM utentiloggatitodo WHERE sessionid = :sessionid";
      $rq = $this->PDO->prepare($query);
      $session_id = session_id();
      $rq->bindParam(":sessionid", $session_id, PDO::PARAM_STR);
      $rq->execute();
    } catch(PDOException $e) {
      echo "Errore di logout";
    }
    if($rq->rowCount() == 0 ) {
      return false;
    
    }
    return true;
  }
  
  public function changePassword($user, $psw, $psw2) {
    //sanification of spaces at the top and at the end
    $cleanPassword = trim($psw);
    $cleanPassword2 = trim($psw2);
    if(!(ctype_alnum($cleanPassword) && mb_strlen($cleanPassword) >= 3 && mb_strlen($cleanPassword) <= 20)) {
      echo "<script>alert('Password troppo lunga lunga o troppo corta!');</script>";
      return false;
    }
    // check of the password
    if(!preg_match('/^[a-zA-Z0-9\+=\!@#\$%]{3,20}$/', $cleanPassword)) {
      echo "<script>alert('Password non valida!');</script>";
      return false;
    }
    // check if password and repeated password are equal
    if(strcmp($cleanPassword, $cleanPassword2) !== 0 ) {
      echo "<script>alert('Password e conferma password non uguali!');</script>";
      return false;
      }
    // encript the password
    $passwordHash = password_hash($cleanPassword, PASSWORD_DEFAULT);
    // now we can launch the query
    try {
    $query = "UPDATE utentitodo SET password=:password WHERE ID = '$user'";
    $rq = $this->PDO->prepare($query);
    $rq->bindParam(":password", $passwordHash, PDO::PARAM_STR);
    $rq->execute();
    $message = "<h3>Modifica della Password Effettuata!</h3>";
    echo $message;
    } catch(PDOException $e) {
        echo "Errore di inserimento nel DB" . $e->getMessage();
    }
    return true;
  }
  
  public function cancelUser($userToCancel) {   // here we will cancel the user from the DB with all his/her TO DO
    try { 
    $query = "DELETE FROM utentitodo WHERE ID = '$userToCancel'";
    $rq = $this->PDO->prepare($query);
    $rq->execute();
    } catch(PDOException $e) {
        echo "Errore di inserimento nel DB" . $e->getMessage();
    }
    try {
    $query = "DELETE FROM utentiloggatitodo WHERE id_logged = '$userToCancel'";
    $rq = $this->PDO->prepare($query);
    $rq->execute();
    } catch(PDOException $e) {
        echo "Errore di inserimento nel DB" . $e->getMessage();
    }
    try {
    $query = "DELETE FROM elencotodo WHERE utente_id = '$userToCancel'";
    $rq = $this->PDO->prepare($query);
    $rq->execute();
    } catch(PDOException $e) {
        echo "Errore di inserimento nel DB" . $e->getMessage();
    }
    session_destroy();
    header('location: index.php');
  }
}

?>