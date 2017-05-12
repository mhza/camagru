<?php
include '../model/Image.class.php';

include '../persistence/ImageDao.class.php';

// include '../config/database.php';

$location = '../index.php';
$target_dir = "../uploads/";
$param_name = str_replace(' ', '_', basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir .$param_name ;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
    //    echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
      //  echo "File is not an image.<br>";
        $uploadOk = 0;
    }
    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.<br>";
    //     $uploadOk = 0;
    // }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
       echo "Sorry, your file is too large.<br>";
       $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // echo "Sorry, your file was not uploaded.<br>";
        $location = "../index.php?upload=ko";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
  //          echo "<script>window.location.replace(\"main_ctrl.php?filter=".$_POST["filterUpload"]."&upload=". $param_name . ");</script>";
              $location = "main_ctrl.php?filter=".$_POST["filterUpload"]."&upload=". $param_name;
        } else {
            // echo "Sorry, there was an error uploading your file.<br>";
            $location = "../index.php?upload=ko";
        }
    }
}

if (!empty($_POST['imgwc']) && !empty($_POST['filter']))
{
// $filter = $_POST['filter'];
    $basename = getcwd() . '/../';
  $img_name = "img64_".date('mdY').'png';
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
  // echo "<img src='".$asmbly_dir.$img_name.".png'>";
}

if(!empty($_GET['upload']))
{
  $basename = getcwd(). '/../';
  // $_GET['upload'] = str_replace(' ', '_', $_GET['upload']);
  $img_name = substr($_GET['upload'], 0, -4) . '.png';
    if(strcmp($_GET['upload'],"ko")){
        // echo "<img src='http://localhost:8080/camagru/uploads/".$_GET['upload']."'>";
        file_put_contents($img_name ,  $basename. $_GET['upload']);
        $im1 = imagecreatefromjpeg(  $basename .'/uploads/'. $_GET['upload']);
        $im2 = imagecreatefrompng(  $basename . "/filtres/". $_GET['filter']);
        imagecopy($im1, $im2, 0, 0, 0, 0, 500, 500);
        imagepng($im1,  $basename . '/assembly/' . $img_name );
        imagedestroy($im1);
        imagedestroy($im2);
        // echo "<img src='".$asmbly_dir.$img_name."'>";
      }

}

if (!empty($_GET['upload']))
{
  try {
  	$dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
  	$imgDao = new ImageDao($dbh);
  } catch (PDOException $e) {
  		// echo 'Database access denied';
  		// echo "<script>window.location.replace(\"../index.php?new_img=ko\");</script>";
  }
  file_put_contents("debug.txt",$imgDao->create("mhaziza@student.42.fr", $img_name));
  $location = "side.php";
  // file_put_contents("debug.txt",count($imgDao->getList()));
  // $imgDao->create("mhaziza@student.42.fr");
}
header("Location: $location");
exit();




?>
