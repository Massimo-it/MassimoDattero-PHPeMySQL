<?php
session_start();

require 'conn.php';
require 'class.php';

$userManagement = new UserManagement($PDO);

// check if users is logged so he/her could access to the reserved pages

if (isset($logged)) {
  
    $sessionid = session_id();

    $query = "SELECT id_logged FROM utentiloggatitodo WHERE sessionid = '$sessionid'";
      $rq = $PDO->prepare($query);
      $rq->execute();
      while ($record = $rq->fetch(PDO::FETCH_ASSOC)) {
        $user = $record['id_logged'];
      }
      
    $query = "SELECT username FROM utentitodo WHERE ID = '$user'";
      $rq = $PDO->prepare($query);
      $rq->execute();
      while ($record = $rq->fetch(PDO::FETCH_ASSOC)) {
        $userName = $record['username'];
      }
  }
?>