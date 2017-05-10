<?php
session_start();
echo "
<html>
  <head>
   <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
  </head>

  <body>
    <div class=\"flex-container\">";
    print_r("index ".$_POST);
    // print_r($_SESSION);
    include 'view/header.php';
    include 'view/side.php';
    include 'view/main.php';

    echo "
        <footer>Copyright &copy;</footer>
        </div>
      </body>
    </html>";
?>
