<?php
$dsn = 'mysql:host=localhost;dbname=contacts2';
$username = 'root';
$password = 'hicham';
$options = [];
try {
$connection = new PDO($dsn, $username, $password, $options);
}
catch(PDOException $e) {
}