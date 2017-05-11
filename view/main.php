<main class="main">
 <h1>ONE MORE PIC</h1>
 <!-- <p>Apercu webcam</p>
 <p>Upload image</p>
 <p>Icons selection</p>
 <p>Button (disable/unable)</p> -->
CHOOSE A FILTER
<?php
  if ($handle = opendir(getcwd() . '/filtres')) {
      while (false !== ($entry = readdir($handle))) {
          if (strlen($entry) >3)
                echo "<a href='#'>
        <img src='"."http://localhost:8080/camagru/filtres/" . $entry ."' alt='".$entry."' style='width:42px;height:42px;border:0;'>
      </a>";
      }
      closedir($handle);
  }
 ?>
<div id = "filters">

</div>
 <p><strong> </strong></p>
 TAKE ONE ?
 <div id="container">
 		<video id="video"></video>
 		<button id="startbutton">Take photo</button>
 		<canvas id="canvas"></canvas>
 	</div><br><br>
UPLOAD ONE ? <br>
<form action="view/main_ctrl.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<?php


if (!empty($_POST['imagwc']))
{
  $img_name = "toto".date('mdY');
  $rawData = json_decode($_POST['imagwc'])->image;
//  $filteredData = explode(',', $rawData);
  $filteredData = str_replace('data:image/png;base64,', '', $rawData);
  $filteredData = str_replace(' ', '+', $filteredData);
  $unencoded = base64_decode($filteredData);
  // file_put_contents('../assembly/post.txt',  $filteredData);
  file_put_contents('../assembly/' . $img_name . '.png', $unencoded);
  $im1 = imagecreatefrompng('../assembly/' . $img_name . '.png');
  $im2 = imagecreatefrompng("../filtres/flowers.png");
  imagecopy($im1, $im2, 0, 0, 0, 0, 500, 500);
  imagepng($im1, '../assembly/' . $img_name . '.png');
  imagedestroy($im1);
  imagedestroy($im2);
  echo "<img src='http://localhost:8080/camagru/assembly/".$img_name.".png'>";

}
if(!empty($_GET['upload']))
{
  $basename=getcwd();
  // $_GET['upload'] = str_replace(' ', '_', $_GET['upload']);
  $img_name = substr($_GET['upload'], 0, -4) . 'png';
  // file_put_contents($img_name . '.png', file_get_contents(  $_GET['upload']));
    if(!strcmp($_GET['upload'],"ko"))
      echo "<p>Try Again</p>";
      else {
        // echo "<img src='http://localhost:8080/camagru/uploads/".$_GET['upload']."'>";
        file_put_contents($img_name ,  $basename. $_GET['upload']);
        $im1 = imagecreatefromjpeg(  $basename .'/uploads/'. $_GET['upload']);
        $im2 = imagecreatefrompng(  $basename . "/filtres/flowers.png");
        imagecopy($im1, $im2, 0, 0, 0, 0, 500, 500);
        imagepng($im1,  $basename . '/assembly/' . $img_name );
        imagedestroy($im1);
        imagedestroy($im2);
        echo "<img src='http://localhost:8080/camagru/assembly/".$img_name."'>";
      }

}
?>
</main>
