<?php
require_once('./database.php');
$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);

$sql = "CREATE DATABASE IF NOT EXISTS camagru";
$dbh->exec( $sql );
$dbh = null;
$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

$sql = "CREATE TABLE IF NOT EXISTS Users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
login VARCHAR(250) NOT NULL,
mail VARCHAR(250) NOT NULL,
pwd VARCHAR(250) NOT NULL,
confKey CHAR(32) NOT NULL,
active CHAR(32)
)";
$dbh->exec( $sql );

$sql = "INSERT INTO `Users` (`id`, `login`, `mail`, `pwd`, `confKey`, `active`) VALUES
(1, 'mh', 'mhaziza@student.42.fr', '42', '2', '1'),
(2, 'tl', 'tl@st.fr', '42', '0', '1'),
(3, 'marine', 'marinehaziza@gmail.com', '42', '2', '1')";

$dbh->exec( $sql );

$sql = "CREATE TABLE IF NOT EXISTS Images (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
likes INT(6) UNSIGNED,
mail VARCHAR(250) NOT NULL,
name VARCHAR(250) NOT NULL,
date DATE NOT NULL
)";
$dbh->exec( $sql );


$sql = "CREATE TABLE IF NOT EXISTS Comments (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idUser INT(6) UNSIGNED,
idImg INT(6) UNSIGNED,
msg VARCHAR(250) NOT NULL
)";

$dbh->exec( $sql );

$sql = "CREATE TABLE `Likes` (
  `id` int(6) NOT NULL,
  `idUser` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$dbh->exec( $sql );

$sql = "ALTER TABLE `test`
  ADD PRIMARY KEY (`id`,`idUser`)";

$dbh->exec( $sql );

$dbh = null;
?>
