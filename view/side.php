<side class="side">
 <h1>GALLERY</h1>
 <?php
 include 'model/Image.class.php';
 include 'persistence/ImageDao.class.php';
 try {
   $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
   $imgDao = new ImageDao($dbh);
 } catch (PDOException $e) {
     // echo 'Database access denied';
     // echo "<script>window.location.replace(\"../index.php?new_img=ko\");</script>";
 }
 $list = $imgDao->getList();
 // echo count ($list);
 // print_r($list);
 $cout = 0;
 foreach ($list as $key=>$img)
  {
    $count++;
     echo "<img src = 'http://localhost:8080/camagru/assembly/".$img->getName()."' style='max-width: 14%;max-height:9%;float:left;'>";
     if (!$count % 3)
        echo "<br>";
  }
 // $homepage = file_get_contents('http://localhost:8080/camagru/view/side.php');
 // echo $homepage;
  ?>
<ul>
 <li><a href="#">All pics done</a></li>
 <li><a href="#">Calendar sort</a></li>
 <li><a href="#">Comments</a></li>
 <li><a href="#">Likes</a></li>
 <li><a href="#">If pic is user's one, can delete</a></li>
</ul>
</side>
