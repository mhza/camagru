<?php
session_start();
include 'view/index_ctrl.php';

echo "
<html>
  <head>
   <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">

  </head>

  <body>
    <div class=\"flex-container\">";
    // print_r("index ".$_POST);
    // if ($_GET['new'])
    // $_SESSION['test']= 'recu';
    //   print_r($_SESSION);
    //   echo "yoyoyoyoyo";
    include 'view/header.php';
    if (!empty($_SESSION['login']))
    {
      // print_r($_SESSION);
      include 'view/side.php';
      include 'view/main.php';
    }

    echo "
        <footer>Copyright &copy;</footer>
        </div>
        <script type=\"text/javascript\" src=\"view/cam_ctrl.js\" async></script>
      </body>
    </html>";
?>
