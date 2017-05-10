<?php
session_start();
include '../model/User.class.php';
include '../persistence/UserDao.class.php';
include '../config/database.php';
// print_r($_POST);
// $_POST['email'] = preg_replace("[^A-Za-z0-9]","", $_POST['email']);
$_POST['pwd'] = preg_replace("[^A-Za-z0-9]","",$_POST['pwd']);

try {
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$userDao = new UserDao($dbh);
} catch (PDOException $e) {
		echo 'Database access denied';
		echo "<script>window.location.replace(\"../index.php?log_in=1&ko=1\");</script>";
}

if (!empty($_POST['email']) && !empty($_POST['pwd']) && !empty($_POST['pwd2']) && !empty($_POST['login']) && !strcmp($_POST['pwd'], $_POST['pwd2'])) {
			$_POST['pwd2'] = preg_replace("[^A-Za-z0-9]","",$_POST['pwd2']);
			$_POST['login'] = preg_replace("[^A-Za-z0-9]","",$_POST['login']);
			$user = new User();
			$user->hydrate(array('mail' => $_POST['email'], 'pwd' => $_POST['pwd'], 'login' => $_POST['login'], 'confKey' => 0));
			if (!$userDao->add($user))
				 echo "<script>window.location.replace(\"../index.php?sign_in=1&ko=1\");</script>";
			$userDao->confirmation_mail($user);
}
else if (!empty($_POST['email']) && !empty($_POST['pwd'])){
			if (!($user =  $userDao->getByMailPwd($_POST['email'], $_POST['pwd'])))
				echo "<script>window.location.replace(\"../index.php?log_in=1&ko=1\");</script>";
			$_SESSION['login'] = $user->getLogin();
}
else if (!empty($_GET['key']) && !empty($_GET['mail'])){
			if (($user =  $userDao->getByMailKey($_GET['mail'], $_GET['key'])))
				$_SESSION['login'] = $user->getLogin();
}
 echo "<script>window.location.replace(\"../index.php\");</script>";
?>