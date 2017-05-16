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
(1, 'marine', 'marinehaziza@gmail.com', '4f3d1d9c8fefc75fc47d9c7aeeb204b92f26b34e06da921e50b1b1e81066a77a88a69f5ced95864cb687cb0134f305f2520b0817f6e8f466c95816dca90afae7', '9a00452c5b18ff90165134cb520c143e', '1'),
(2, 'mawina', 'mhaziza@student.42.fr', '4f3d1d9c8fefc75fc47d9c7aeeb204b92f26b34e06da921e50b1b1e81066a77a88a69f5ced95864cb687cb0134f305f2520b0817f6e8f466c95816dca90afae7', '538ff34333a30608d74fdc6bf4f74ddf', '1')";

$dbh->exec( $sql );

$sql = "CREATE TABLE IF NOT EXISTS Images (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
likes INT(6) UNSIGNED,
mail VARCHAR(250) NOT NULL,
name VARCHAR(250) NOT NULL,
date DATE NOT NULL
)";
$dbh->exec( $sql );

$sql = "INSERT INTO `Images` (`id`, `likes`, `mail`, `name`, `date`) VALUES
(1, 0, 'marinehaziza@gmail.com', 'img64__17160522:58:23.png', '2017-05-16'),
(2, 0, 'marinehaziza@gmail.com', 'img64__17160522:58:31.png', '2017-05-16'),
(3, 1, 'marinehaziza@gmail.com', 'img64__17160522:58:37.png', '2017-05-16'),
(4, 0, 'marinehaziza@gmail.com', 'img64__17160522:58:42.png', '2017-05-16'),
(5, 0, 'marinehaziza@gmail.com', 'img64__17160522:58:44.png', '2017-05-16'),
(6, 1, 'marinehaziza@gmail.com', 'img64__17160522:58:50.png', '2017-05-16'),
(7, 1, 'mhaziza@student.42.fr', 'img64__17160523:00:00.png', '2017-05-16'),
(8, 1, 'mhaziza@student.42.fr', 'img64__17160523:00:13.png', '2017-05-16'),
(9, 12, 'marinehaziza@gmail.com', 'img64__17160523:01:20.png', '2017-05-16')";

$dbh->exec( $sql );

$sql = "CREATE TABLE IF NOT EXISTS Comments (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idUser INT(6) UNSIGNED,
idImg INT(6) UNSIGNED,
msg VARCHAR(250) NOT NULL
)";

$dbh->exec( $sql );

$sql = "INSERT INTO `Comments` (`id`, `idUser`, `idImg`, `msg`) VALUES
(1, 2, 3, 'great'),
(2, 2, 2, 'S^2'),
(3, 2, 1, 'no face ?'),
(4, 2, 7, 'cloudy day'),
(5, 2, 8, 'i\'m like a bird'),
(6, 2, 8, 'me tooooo !!!'),
(7, 1, 9, 'soooo cuute'),
(8, 1, 9, '<3<3<3')";

$dbh->exec( $sql );

$sql = "CREATE TABLE `Likes` (
  `id` int(6) NOT NULL,
  `idUser` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$dbh->exec( $sql );

$sql = "INSERT INTO `Likes` (`id`, `idUser`) VALUES
(6, 2),
(3, 2),
(7, 2),
(8, 2),
(9, 1)";

$dbh->exec( $sql );

$sql = "ALTER TABLE `Likes`
  ADD PRIMARY KEY (`id`,`idUser`)";

$dbh->exec( $sql );

$dbh = null;
?>
