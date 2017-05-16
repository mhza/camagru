<?php
include_once '../model/Image.class.php';
include_once '../persistence/ImageDao.class.php';

// include '../config/database.php';
session_start();
$location = '../index.php';
$target_dir = "../uploads/";
$param_name = str_replace(' ', '_', basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir .$param_name ;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(!empty($_POST["submit"]) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
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
      //  echo "Sorry, your file is too large.<br>";
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
  // $location = "../index.php?filter=".$_POST["filterUpload"]."&upload=". $param_name;
    $_SESSION['filter']= $_POST["filterUpload"];
    $_SESSION['upload']= $param_name;
              $location = "../index.php";
        } else {
            // echo "Sorry, there was an error uploading your file.<br>";
            $location = "../index.php?upload=ko";
        }
    }
}
// file_put_contents("debug.txt", "noped");
header("Location: $location");
exit();




?>
