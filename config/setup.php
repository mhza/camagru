<?php
require_once('./database.php');
$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
// Create dbbase if note exist
$sql = "CREATE DATABASE IF NOT EXISTS camagru";
$dbh->exec( $sql );
$dbh = null;
$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
// Create User Table
$sql = "CREATE TABLE IF NOT EXISTS Users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
login VARCHAR(250) NOT NULL,
mail VARCHAR(250) NOT NULL,
pwd VARCHAR(250) NOT NULL,
confKey CHAR(32) NOT NULL
)";
$dbh->exec( $sql );

$sql = "INSERT INTO `Users` (`id`, `login`, `mail`, `pwd`, `confKey`) VALUES
(1, 'mh', 'mhaziza@student.42.fr', '42', '2'),
(2, 'tl', 'tl@st.fr', '42', '0'),
(3, 'marine', 'marinehaziza@gmail.com', '42', '2')";
$dbh->exec( $sql );
$dbh = null;
?>
