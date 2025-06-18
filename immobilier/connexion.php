<?php
session_start();
$connexion = new mysqli("localhost", "ETU004364", "6rZtjtKe", "db_s2_ETU004364");
if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}
?>
