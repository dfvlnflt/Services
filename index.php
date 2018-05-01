<?php
    session_start();
    if (isset($_SESSION['uid']))
    {
      $user_id = $_SESSION['uid'];
    }
    else {
      $user_id = 0;
      $user_first_name = "Unknown User";
    }

      /* Show error message - REMOVE DURING PRODUCTION */

      error_reporting(E_ALL);

      ini_set('display_errors', 1);


      $conn = new mysqli("localhost", "root", "root", "marketing","3306");
      if ($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

      $sql = "SELECT user_id, first_name FROM user WHERE user_id=$user_id";
      $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
      while ($row = mysqli_fetch_array($res)){
        $user_first_name = $row['first_name'];
      }

      $title[0] = "Welcome to Rollins";
      $title[1] = "This is a test";
      $title[2] = "Beautiful Campus";
      $title[3] = "Park Ave.";
      $img[0] = "https://assets.vice.com/content-images/contentimage/no-slug/1730f6770d9cfc661b5269accc048475.jpg";
      $img[1] = "http://www.whartonsmith.com/wp-content/uploads/2015/12/Rollins-Presidents-House-1-700x0-c-default.jpg";
      $img[2] = "http://www.rollins.edu/images-department/main-images/rollins-college-campus-lake-virginia-overhead.jpg";
      $img[3] = "http://www.rollins.edu/images-department/main-images/rollins-college-front-gate.jpg";

      require_once 'pear/IT.php';

      $tpl = new HTML_Template_IT();

      /* LOAD SPECIFIC TEMPLATE FILE */

      $tpl->loadTemplatefile('templates/index.tpl.htm', true, true);

      $pageTitle = "Rollins Test";

      $tpl->setCurrentBLock("TITLE");
      $tpl->setVariable("PAGE_TITLE", $pageTitle);
      $tpl->parseCurrentBlock();

      $tpl->setCurrentBLock("CONTENT");
      $tpl->setVariable("HEADER", $pageTitle);
      $tpl->setVariable("USER_FIRST_NAME", $user_first_name);
      $tpl->parseCurrentBlock();

      for($x = 0; $x <4; $x++){
        $tpl->setCurrentBLock("CARD");
        $tpl->setVariable("CARD_IMG", $img[$x]);
        $tpl->setVariable("CARD_TITLE", $title[$x]);
        $tpl->parseCurrentBlock();
      }

      //No variables --just touch block
      //$tpl->touchBlock("CONTENT");

      $tpl->show();

?>
