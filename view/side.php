<side class="side">
 <h1>GALLERY</h1>

 <?php
 include_once 'model/Image.class.php';
 include_once 'persistence/ImageDao.class.php';
 try {
   $dbh = new PDO('mysql:host=localhost;dbname=camagru', 'username', 'password');
   $imgDao = new ImageDao($dbh);
 } catch (PDOException $e) {
     // echo 'Database access denied';
     // echo "<script>window.location.replace(\"../index.php?new_img=ko\");</script>";
 }

   $list = $imgDao->getList();
  //  print_R
   $cout = 0;
   foreach ($list as $key=>$img)
    {
      $count++;
       echo "<img src = 'http://localhost:8080/camagru/assembly/".$img->getName()."' style='max-width: 140px;max-height:90px;width: 14%;'>";
       if (!$count % 3)
          echo "<br>";
    }
  ?>
<ul>
 <li><a href="#">All pics done</a></li>
 <li><a href="#">Calendar sort</a></li>
 <li><a href="#">Comments</a></li>
 <li><a href="#">Likes</a></li>
 <li><a href="#">If pic is user's one, can delete</a></li>
</ul>
</side>
