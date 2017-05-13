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
   $count = 0;
   foreach ($list as $key=>$img)
    {
      $count++;
      $is_liked = 0;
      $color= 'black';
      $label= 'LIKE';
      $idImg  = $img->getId();
      $idUser  = $_SESSION['idUser'];
      $ret=0;
      $ret = $imgDao->getLike( $idImg, $idUser);
      if ($ret > 0)
      {
        $is_liked = 1;
        $color= 'pink';
        $label ='LIKED';
      }
      // print_r($retCom);
      echo "<div><img src = 'http://localhost:8080/camagru/assembly/".$img->getName()."' style='max-width: 280px;max-height:180px;width: 50%;'><br>
       <button id = 'like".$count."' style='color:".$color.";' onclick='like_unlike(".$is_liked.", ".$count.", ".$idImg.", ".$img->getLikes().")'>".$label." </button> ".$img->getLikes();
      $retCom = $imgDao->getComments($idImg);
      // print_r($retCom);
      echo " // ".count($retCom)." comments<br>";
      foreach ($retCom as $key => $value) {
        echo "> ".$value['msg']."<br>";
      }
    echo "
    <input id = 'com".$count."' placeholder=\"yours\" maxlength='50' type=\"text\" name=\"com\"/>
    <input onclick = 'new_comments( ".$idImg.", ".$count.")' class='button' type=\"submit\" name=\"clic\" value = \"+ \" /><br/>
    ";
    if (!strcmp($_SESSION['mail'],$img->getMail()) )
      echo "<input onclick = 'deleteImg( ".$idImg.")' class='button-bk' type=\"submit\" name=\"delete\" value = \"DELETE \" />";

    echo "<br/><hr>";
      ?>

      </div>

      <?php

    }
  ?>

</side>

<script>
function like_unlike(is_liked, count, id, likes){
  var element = document.getElementById("like" + count);
  if (!is_liked)
  {
    likes += 1;
    var params = "like=" + likes + "&id=" + id + "&is_liked=0";
  }
  else
  {
    likes -= 1;
    var params = "like=" + likes + "&id=" + id + "&is_liked=1";
  }
  var http = new XMLHttpRequest();
  var url = "index.php";
  http.open("POST", url, true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.onreadystatechange = function() {//Call a function when the state changes.
      if(http.readyState == 4 && http.status == 200) {
          window.location.reload(true);
      }
  }
  http.send(params);
}

function new_comments(idImg, count){
  var http = new XMLHttpRequest();
  var url = "index.php";
  var params = "comment=" + document.getElementById('com' + count).value + "&idImg=" + idImg;
  http.open("POST", url, true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.onreadystatechange = function() {//Call a function when the state changes.
      if(http.readyState == 4 && http.status == 200) {
           window.location.reload(true);
      }
  }
  http.send(params);
}

function deleteImg(idImg){
  var http = new XMLHttpRequest();
  var url = "index.php";
  var params = "delete=" + idImg;
  http.open("POST", url, true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.onreadystatechange = function() {//Call a function when the state changes.
      if(http.readyState == 4 && http.status == 200) {
           window.location.reload(true);
      }
  }
  http.send(params);
}
</script>
