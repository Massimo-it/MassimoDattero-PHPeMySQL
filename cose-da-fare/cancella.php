<?php

require './include/conn.php';

$delete = $_GET['delete'];

// query to eliminate the TO DO 

$query = "DELETE FROM elencotodo WHERE ID = $delete";
$rq = $PDO->prepare($query);
$rq->execute();
header ('location: elenco.php');

?>