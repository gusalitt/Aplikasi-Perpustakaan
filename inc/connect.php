<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'perpustakaan';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  echo "Sepertinya ada kesalahan sistem...";
}
?>