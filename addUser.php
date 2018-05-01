<?php
//session_start();

/***Error messages***/
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nameErr = "";

/***Connecting to database***/
$conn = new mysqli("localhost", "root", "root", "marketing","3306");
if ($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

/*
if (isset($_POST['submit']))
{
  if (empty($_POST['firstName'])) {
    $nameErr = "Name is required";
  } else {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  }
  //$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  //$firstName = $_POST["firstName"];
  $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
  //$lastName = $_POST["lastName"];
  $jobTitle = mysqli_real_escape_string($conn, $_POST['jobTitle']);
  //$jobTitle = $_POST['jobTitle'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  // user-service.php?action=search-a


  $sql = "SELECT count(*) user_count FROM user WHERE username = '$username'";
  $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
  $row = mysqli_fetch_assoc($res);
  if($row['user_count'] >= 1) //mysqli_num_rows($check)>=1
   {
    echo"name already exists";
   }
 else
    {
      $sql = "INSERT INTO user (first_name, last_name, job_jobTitle, email, username, password)
              VALUES ('$firstName','$lastName', '$jobTitle', '$email', '$username', sha1('$password'))";
      $result = mysqli_query($conn,$sql);
    }
  //$sql = "INSERT INTO user (first_name, last_name, job_jobTitle, email, username, password)
    //      VALUES ('$firstName','$lastName', '$jobTitle', '$email', '$username', sha1('$password'))";
  //$result = mysqli_query($conn,$sql);
}*/



/*Load template*/
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();
$tpl->loadTemplatefile('templates/addUser.tpl.htm', true, true);

/* Content */
$pageTitle = "Add User";

$tpl->setCurrentBLock("HEADER");
$tpl->setVariable("HEADER", $pageTitle);
$tpl->parseCurrentBlock();

$tpl->setCurrentBlock("FORM");
$tpl->setVariable("PHP_ERROR", $nameErr);
$tpl->parseCurrentBlock();

$tpl->show();

 ?>
