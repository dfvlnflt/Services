
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
$tpl->loadTemplatefile('templates/addAssignment.tpl.htm', true, true);

$url = "http://localhost:8888/rollins/services/service-service.php";
$myvars = "action=get";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$resp= json_decode($response, true);
if ($resp["responseCode"] == 200)
{
  $noRecords = sizeof($resp["data"]);
  for ($x=0; $x<$noRecords; $x++){
    $sid = $resp["data"][$x]["sid"];
    $name = $resp["data"][$x]["name"];

    $tpl->setCurrentBlock("SELECTION_BOX");
    $tpl->setVariable("SERVICE_ID", $sid);
    $tpl->setVariable("SERVICE_NAME", $name);
    $tpl->parseCurrentBlock();
  }
}

$pageTitle = "Add Assignment";

$tpl->setCurrentBLock("HEADER");
$tpl->setVariable("HEADER", $pageTitle);
$tpl->parseCurrentBlock();

$tpl->touchBlock("FORM");


$tpl->show();

 ?>
