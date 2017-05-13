<?PHP
    echo "<header> <h1>Ca<span style='color : pink;'>ma</span>g<span style='color : pink;'>r</span>u</h1> ";

    if (!empty($_SESSION['login']) && empty($_GET['log_out'])) {
     echo " Hi ". $_SESSION['login']."<a class='log' href='index.php?log_out=1'> LOG OUT </a>";
    }
    else if (!empty($_GET['log_in'])) {

      echo "
      <form class='log' action=\"view/header_ctrl.php\" method=\"post\">
        <label for=\"email\"></label><br>
          <input placeholder=\"@\" type=\"mail\" name=\"email\"/><br/>
        <label for=\"pwd\"></label><br>
          <input placeholder=\"password\"  type=\"password\" name=\"pwd\"/><br/>

        <br><input class='button-bk' type=\"submit\" name=\"clic\" value = \"clic\"/><br/>";
      if (!empty($_GET['ko']))
        echo "Try again</form>";
      else
        echo "</form><br>";
        echo "<a class='log' href='index.php'> <<< </a>";
        echo "<a class='log' href='index.php?initpwd=1' > init pwd </a>";

    }
    else if (!empty($_GET['sign_in'])){
      echo "
      <form class='log' action=\"view/header_ctrl.php\" method=\"post\">
        <label for=\"email\"></label><br>
          <input placeholder=\"@\" type=\"email\" name=\"email\"/><br/>
        <label for=\"login\"></label><br>
          <input placeholder=\"login\" type=\"text\" name=\"login\"/><br/>
        <label for=\"pwd\"></label><br>
          <input placeholder=\"password\" type=\"password\" name=\"pwd\"/><br/>
        <label for=\"pwd2\"></label><br>
          <input placeholder=\"confirm password\" type=\"password\" name=\"pwd2\"/><br/>

        <input class='button-bk' type=\"submit\" name=\"clic\"value = \"clic\" /><br/>";
        if (!empty($_GET['ko']))
          echo "Try again</form>";
        else
          echo "</form>";
          echo "<a class='log' href='index.php'> <<< </a>";
    }
    else if (!empty($_GET['initpwd'])){
      echo "
      <form class='log' action=\"view/header_ctrl.php\" method=\"post\">
        <label for=\"email\"></label><br>
          <input placeholder=\"@\" type=\"email\" name=\"initpwdmail\"/><br/>

        <input onclick = 'inipwdbymail()' class='button-bk' type=\"submit\" name=\"clic\"value = \"send me a link\" /><br/>";
        if (!empty($_GET['ko']))
          echo "Try again</form>";
        else
          echo "</form>";
          echo "<a class='log' href='index.php'> <<< </a>";
    }
    else if (!empty($_GET['reset'])){
      echo "
      <form class='log' action=\"view/header_ctrl.php\" method=\"post\">
      <label for=\"pwd\"></label><br>
        <input id='resetpwdid' placeholder=\"password\" type=\"password\" name=\"pwd\"/><br/>
      <label for=\"pwd2\"></label><br>
        <input id='resetpwdid2' placeholder=\"confirm password\" type=\"password\" name=\"pwd2\"/><br/>

        <input onclick = 'inipwd(".$_GET['reset'].",".$_GET['key'].")' class='button-bk' type=\"submit\" name=\"clic\"value = \"reset\" /><br/>";
          echo "</form>";
          echo "<a class='log' href='index.php'> <<< </a>";
    }
    else {
      if (!empty($_GET['log_out'])){
        session_destroy();
      }
      echo "<a class='log' href='index.php?log_in=1'> LOG IN </a>
            <a class='log' href=\"index.php?sign_in=1\"> SIGN IN </a>";
    }
echo "</header>";
?>
<script>
function inipwdbymail()
{
  var http = new XMLHttpRequest();
  var url = "index.php";
  var params = "initpwdmail=" + document.getElementById('initpwdmail').value;
  http.open("POST", url, true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.onreadystatechange = function() {//Call a function when the state changes.
      if(http.readyState == 4 && http.status == 200) {
          //  window.location.reload(true);
      }
  }
  http.send(params);
}

function inipwd(mail, key)
{
  var url = "index.php";
  var pwd = document.getElementById('initpwdmail').value;
  var pwd2 = document.getElementById('initpwdmail2').value;
  if (pwd == pwd2)
  {
    var http = new XMLHttpRequest();
    var params = "resetpwd=" + pwd + "&mail=" + mail + "&key=" + key;
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
             window.location.reload(true);
        }
    }
    http.send(params);
  }
}
</script>
