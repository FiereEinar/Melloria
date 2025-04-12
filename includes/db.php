<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

$conn = new mysqli($servername, $username, $password, $dbname);

try {
  $pdo = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
} catch (PDOException $e) {
  die("Connection failed: ". $e->getMessage());
}