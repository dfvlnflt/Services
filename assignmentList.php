<?php
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();
include ('../includes/db-connect.php');

$tpl->loadTemplatefile('templates/assignmentList.tpl.htm', true, true);

// LOGO HEADER
$tpl->touchBlock("LOGO");

// TABLE
$url = "http://localhost:8888/rollins/services/assignment-service.php";
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
    $aid = $resp["data"][$x]["aid"];
    $justification = $resp["data"][$x]["justification"];
    $bann_ntid = $resp["data"][$x]["bann_ntid"];

    $tpl->setCurrentBlock("TABLE");
    $tpl->setVariable("AID", $aid);
    $tpl->setVariable("JUSTIFICATION", $justification);
    $tpl->setVariable("BANN_NTID", $bann_ntid);
    $tpl->parseCurrentBlock();
  }
}

$tpl->touchBlock("BUTTON");

$tpl->show();
 ?>
