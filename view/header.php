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
        echo "</form>";
        echo "<a class='log' href='index.php'> Back </a>";

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
        echo "<a class='log' href='index.php'> Back </a>";
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
