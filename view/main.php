<main class="main">
 <h1>ONE MORE PIC ?</h1>
 <!-- <p>Apercu webcam</p>
 <p>Upload image</p>
 <p>Icons selection</p>
 <p>Button (disable/unable)</p> -->
 <hr>
1 / CHOOSE A FILTER<br>
<?php
$filters_dir = "http://localhost:8080/camagru/filtres/";
$asmbly_dir = "http://localhost:8080/camagru/assembly/";
$path = getcwd();
  if ($handle = opendir($path . '/filtres')) {
      while (false !== ($entry = readdir($handle))) {
          if (strlen($entry) >3)
                echo "<img onclick='is_selected(\"". $entry ."\")' src='".$filters_dir . $entry ."' id='filter' value='" . $entry ."' style='width:7%;border:0;'>";
      }
      closedir($handle);
  }
 ?>


<div id = "selected"></div>
<hr>
2 / ADD YOUR PIC  <br><br>
-> TAKE a new ONE <-

 <div id="webcam">
    <video id="video"></video>
 		<input id="filter" type="hidden" name = "filter"></input>
 		<button id="startbutton" disabled="true">Take photo</button>
 		<canvas id="canvas"></canvas>
 	</div><br><br>



<div id="upload" >
-> or UPLOAD ONE <-<br>
<form action="view/main_ctrl.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload" disabled="true">
    <input id="filterUpload" type="hidden" name = "filterUpload" ></input>
    <input id ="uploadbtn" type="submit" value="Upload Image" name="submit" disabled="true">
</form>
</div>



</main>
<script>
// function is_visible(filter){
//   return   document.getElementById(filter).visiblity;
// }

function is_selected(filter){
  var element = document.getElementById("selected");
  element.innerHTML = "SELECTED <br><img src='http://localhost:8080/camagru/filtres/" + filter + "' id='"+ filter +"' style='width:42px;height:42px;border:0;'>";
  document.getElementById("filter").value = filter;
  document.getElementById("filterUpload").value = filter;
  document.getElementById("startbutton").disabled = false;
  document.getElementById("uploadbtn").disabled = false;
  document.getElementById("fileToUpload").disabled = false;
  document.getElementById("bigdiv").disabled = false;
  // document.getElementById("webcam").visiblity="visible";
  // document.getElementById("upload").visiblity="visible";
}
</script>
