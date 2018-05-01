<?php
session_start();
//$_SESSION['uid'] = 3;

/*Connecting to database*/
$conn = new mysqli("localhost", "root", "root", "marketing","3306");
if ($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

if (isset($_POST['submit']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT user_id FROM user WHERE username = '$username' AND password = sha1('$password')";
  $res = mysqli_query($conn, $sql);
  $ct = 0;
  while ($row = mysqli_fetch_array($res))
  {
    $ct++;
    $user_id = $row['user_id'];
    $_SESSION['uid'] = $user_id;
  }
  header('Location: home.php');
}

/*Load template*/
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();
$tpl->loadTemplatefile('templates/login.tpl.htm', true, true);

/* Content */
//$tpl->touchBlock("LOGO");
//$pageTitle = "Login";

//$tpl->setCurrentBLock("HEADER");
//$tpl->setVariable("HEADER", $pageTitle);
//$tpl->parseCurrentBlock();

$tpl->touchBlock("FORM");
//$tpl->touchBlock("NEWUSER");

$tpl->touchBlock("MODAL");


$tpl->show();

 ?>
