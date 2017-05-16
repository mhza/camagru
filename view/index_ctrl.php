<?php
include_once 'model/Image.class.php';
include_once 'model/User.class.php';
include_once 'persistence/ImageDao.class.php';
include_once 'persistence/UserDao.class.php';

if(!empty($_SESSION['upload'])&& !empty($_SESSION['filter']))
{
  $basename = getcwd();
  // $_GET['upload'] = str_replace(' ', '_', $_GET['upload']);
  // date("ydm").date("H:i:s")
    if(strcmp($_SESSION['upload'],"ko")){
        // echo "<img src='http://localhost:8080/camagru/uploads/".$_GET['upload']."'>";
        // file_put_contents($img_name ,  $basename. $_GET['upload']);

        if (!strcmp(strtolower(substr($_SESSION['upload'], -4)), ".jpg"))
        {
          $img_name = substr($_SESSION['upload'], 0, -4) ."_".date("ydm").date("H:i:s"). '.png';
          $im1 = imagecreatefromjpeg(  $basename .'/uploads/'. $_SESSION['upload']);
        }
        else if (!strcmp(strtolower(substr($_SESSION['upload'], -4)), ".png"))
        {
          $img_name = substr($_SESSION['upload'], 0, -4) ."_".date("ydm").date("H:i:s"). '.png';
          $im1 = imagecreatefrompng(  $basename .'/uploads/'. $_SESSION['upload']);
        }
        else {
          echo strtolower(substr($_SESSION['upload'], -4));
          $_SESSION['upload']="";
          $_SESSION['filter']="";
              return;
        }
        $im2 = imagecreatefrompng(  $basename . "/filtres/". $_SESSION['filter']);
        imagecopy($im1, $im2, 0, 0, 0, 0, 500, 500);
        imagepng($im1,  $basename . '/assembly/' . $img_name );
        imagedestroy($im1);
        imagedestroy($im2);
        // delete($basename .'/uploads/'. $_GET['upload']);
        // echo "<img src='".$asmbly_dir.$img_name."'>";
        try {
          $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
          $imgDao = new ImageDao($dbh);
        } catch (PDOException $e) {
            // echo 'Database access denied';
            // echo "<script>window.location.replace(\"../index.php?new_img=ko\");</script>";
        }
        $imgDao->create($_SESSION['mail'], $img_name);

      }
      $_SESSION['upload']="";
      $_SESSION['filter']="";

}

// print_r($_POST);
if (!empty($_POST['imgwc']) && !empty($_POST['filter']))
{
// $filter = $_POST['filter'];
  $basename = getcwd() ;
  $img_name = "img64_"."_".date("ydm").date("H:i:s").'.png';
  $rawData = json_decode($_POST['imgwc'])->image;
//  $filteredData = explode(',', $rawData);
  $filteredData = str_replace('data:image/png;base64,', '', $rawData);
  $filteredData = str_replace(' ', '+', $filteredData);
  $unencoded = base64_decode($filteredData);

  file_put_contents($basename . '/assembly/' . $img_name, $unencoded);
  $im1 = imagecreatefrompng($basename . '/assembly/' . $img_name);
  $im2 = imagecreatefrompng($basename . "/filtres/" . $_POST['filter']);
  imagecopy($im1, $im2, 0, 0, 0, 0, 500, 500);
  imagepng($im1, $basename . '/assembly/' . $img_name);
  imagedestroy($im1);
  imagedestroy($im2);
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
    $imgDao = new ImageDao($dbh);
  } catch (PDOException $e) {
      // echo 'Database access denied';
      // echo "<script>window.location.replace(\"../index.php?new_img=ko\");</script>";
  }
  $imgDao->create($_SESSION['mail'], $img_name);
  // echo "<img src='".$asmbly_dir.$img_name.".png'>";
}

if(($_POST['like'] != "" )&& !empty($_POST['id']))
{
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
    $imgDao = new ImageDao($dbh);
  } catch (PDOException $e) {
  }
  $imgDao->updateLike($_POST['id'], $_POST['like']);
  if ($_POST['is_liked'] == 1)
    $imgDao->deleteLike($_POST['id'], $_SESSION['idUser']);
  else {
    $imgDao->createLike($_POST['id'], $_SESSION['idUser']);
  }
  // header("Location :index.php");
}

if($_POST['comment'] != "" && !empty($_POST['idImg']))
{
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
    $imgDao = new ImageDao($dbh);
  } catch (PDOException $e) {
  }
  $imgDao->addComments($_POST['idImg'], $_SESSION['idUser'], $_POST['comment']);
  $img = $imgDao->getImg($_POST['idImg']);
  $imgDao->new_comment_mail($img->getName(), $img->getMail(), $_POST['comment']);
}

if($_POST['delete'] != "")
{
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
    $imgDao = new ImageDao($dbh);
  } catch (PDOException $e) {
  }
  $imgDao->delete($_POST['delete']);

}

if($_POST['initpwdmail'] != "")
{
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
    $userDao = new UserDao($dbh);
  } catch (PDOException $e) {
  }
  $id = $userDao->getIdByMail($_POST['initpwdmail']);
  // echo $_POST['initpwdmail']." id ".$id;
  // file_put_contents("debug.txt", "noped");
  if ($id)
    $userDao->init_pwd_mail($userDao->get($id));
}
if(!empty($_POST['resetpwd']))
{
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
    $userDao = new UserDao($dbh);
  } catch (PDOException $e) {
  }
  // file_put_contents("debug.txt", "noped");
  $id = $userDao->getIdByMail($_POST['mail']);
  // echo $_POST['resetpwd']." id ".$id;
  $user = $userDao->get($id);
  if ($user){
    $user->setPwd(hash("whirlpool", $_POST['resetpwd']));
    $userDao->update($user);
  }
}
if (!empty($_POST['log_out'])){
  session_destroy();
}
 ?>
