
<?php
//session_start();

/***Error messages***/
error_reporting(E_ALL);
ini_set('display_errors', 1);


/***Connecting to database***/
$conn = new mysqli("localhost", "root", "root", "marketing","3306");
if ($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

/*Load template*/
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();
$tpl->loadTemplatefile('templates/addService.tpl.htm', true, true);

/* Content */
$pageTitle = "Add Service";

$tpl->setCurrentBLock("HEADER");
$tpl->setVariable("HEADER", $pageTitle);
$tpl->parseCurrentBlock();

$tpl->touchBlock("FORM");

$tpl->show();

 ?>
