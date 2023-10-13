<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'printservice';
$conn = new mysqli($server, $username, $password, $database, 3306) or die("Can not 
        connect to database!");
?>