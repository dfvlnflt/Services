<?php
session_start();
include ('includes/db-connect.php');
if (isset($_GET['pg']))
  $pg = $_GET['pg'];
else {
  $pg = 1;
}

/*** LOAD TEMPLATE ***/
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();
$tpl->loadTemplatefile('templates/home.tpl.htm', true, true);


/*** LOAD BUTTONS AND LOGO***/
$tpl->touchBlock("LOGO");
$tpl->touchBlock("BUTTONS");



/*** ASSIGNMENTS TABLE ***/

$urlAssignment = "http://localhost:8888/rollins/services/assignment-service.php";
$myvarsAssignment = "action=get";
$chAssignment = curl_init($urlAssignment);
curl_setopt($chAssignment, CURLOPT_POST, 1);
curl_setopt($chAssignment, CURLOPT_POSTFIELDS, $myvarsAssignment);
curl_setopt($chAssignment, CURLOPT_RETURNTRANSFER, 1);
$responseAssignment = curl_exec($chAssignment);
$respAssignment= json_decode($responseAssignment, true);

if ($respAssignment["responseCode"] == 200)
{
  $noRecordsAssignment = sizeof($respAssignment["data"]);
  $tableShow = $noRecordsAssignment;

  for ($x=0; $x<$tableShow; $x++){
    $aid = $respAssignment["data"][$x]["aid"];
    $justification = $respAssignment["data"][$x]["justification"];
    $bann_ntid = $respAssignment["data"][$x]["bann_ntid"];

    $sid = $respAssignment["data"][$x]["sid"];
    $service_name = $respAssignment["data"][$x]["service_name"];
    $service_description = $respAssignment["data"][$x]["service_description"];
    $service_url = $respAssignment["data"][$x]["service_url"];
    $service_ecn = $respAssignment["data"][$x]["service_ecn"];
    $service_ecp = $respAssignment["data"][$x]["service_ecp"];
    $service_ece = $respAssignment["data"][$x]["service_ece"];
    $service_no_license = $respAssignment["data"][$x]["service_no_license"];
    $service_icn = $respAssignment["data"][$x]["service_icn"];
    $service_icp = $respAssignment["data"][$x]["service_icp"];
    $service_ice = $respAssignment["data"][$x]["service_ice"];
    $service_cost = $respAssignment["data"][$x]["service_cost"];
    $service_cost_unit = $respAssignment["data"][$x]["service_cost_unit"];
    $service_contract_date = $respAssignment["data"][$x]["service_contract_date"];
    $service_renewal_date = $respAssignment["data"][$x]["service_renewal_date"];
    $service_contract_id = $respAssignment["data"][$x]["service_contract_id"];

    $tpl->setCurrentBlock("TABLE");
    $tpl->setVariable("AID", $aid);
    $tpl->setVariable("SERVICE_NAME", $service_name);
    $tpl->setVariable("JUSTIFICATION", $justification);
    $tpl->setVariable("TBL_SERVICE_ID", $sid);
    $tpl->setVariable("BANN_NTID", $bann_ntid);
    $tpl->setVariable("ASSINGMENT_UPDATE_ID", $aid);
    $tpl->parseCurrentBlock();

    $tpl->setCurrentBlock("MODAL");
    $tpl->setVariable("SERVICE_ID", $sid);
    $tpl->setVariable("SERVICE_NAME_MODAL", $service_name);

    $tpl->setVariable("SERVICE_SID_MODAL", $sid);
    $tpl->setVariable("SERVICE_DESCRIPTION_MODAL", $service_description);
    $tpl->setVariable("SERVICE_URL_MODAL", $service_url);
    $tpl->setVariable("SERVICE_ECN_MODAL", $service_ecn);
    $tpl->setVariable("SERVICE_ECP_MODAL", $service_ecp);
    $tpl->setVariable("SERVICE_ECE_MODAL", $service_ece);
    $tpl->setVariable("SERVICE_NO_LICENSE_MODAL", $service_no_license);
    $tpl->setVariable("SERVICE_ICN_MODAL", $service_icn);
    $tpl->setVariable("SERVICE_ICP_MODAL", $service_icp);
    $tpl->setVariable("SERVICE_ICE_MODAL", $service_ice);
    $tpl->setVariable("SERVICE_COST_MODAL", $service_cost);
    $tpl->setVariable("SERVICE_COST_UNIT_MODAL", $service_cost_unit);
    $tpl->setVariable("SERVICE_CONTRACT_DATE_MODAL", $service_contract_date);
    $tpl->setVariable("SERVICE_RENEWAL_DATE_MODAL", $service_renewal_date);
    $tpl->setVariable("SERVICE_CONTRACT_ID_MODAL", $service_contract_id);
    $tpl->parseCurrentBlock();


    $tpl->setCurrentBlock("MODALASSIGNUPDATE");
    $tpl->setVariable("UPDATE_AID", $aid);
    $tpl->setVariable("AID_UPDATE", $aid);
    $tpl->setVariable("CURRENT_JUSTIFICATION", $justification);
    $tpl->setVariable("CURRENT_BANN_NTID", $bann_ntid);

    $tpl->setVariable("SERVICE_ID", $sid);
    $tpl->setVariable("SERVICE_NAME", $service_name);

    $tpl->parseCurrentBlock();

  }
}



/*** TABLE SERVICE ***/
$urlService = "http://localhost:8888/rollins/services/service-service.php";
$myvarsService = "action=get";
$chService = curl_init($urlService);
curl_setopt($chService, CURLOPT_POST, 1);
curl_setopt($chService, CURLOPT_POSTFIELDS, $myvarsService);
curl_setopt($chService, CURLOPT_RETURNTRANSFER, 1);
$responseService = curl_exec($chService);
$respService= json_decode($responseService, true);

if ($respService["responseCode"] == 200)
{
  $noRecordsService = sizeof($respService["data"]);
  for ($x=0; $x<$noRecordsService; $x++){
    $sid = $respService["data"][$x]["sid"];
    $service_name = $respService["data"][$x]["name"];
    $max_license= $respService["data"][$x]["no_license"];
    $licenseRequired = $respService["data"][$x]["licenseRequired"];
    $description = $respService["data"][$x]["description"];
    $url = $respService["data"][$x]["url"];
    $ecn = $respService["data"][$x]["ext_contact_name"];
    $ecp = $respService["data"][$x]["ext_contact_phone"];
    $ece = $respService["data"][$x]["ext_contact_email"];
    $icn = $respService["data"][$x]["int_contact_name"];
    $icp = $respService["data"][$x]["int_contact_phone"];
    $ice = $respService["data"][$x]["int_contact_email"];
    $cost = $respService["data"][$x]["cost"];
    $cost_unit = $respService["data"][$x]["cost_unit"];
    $contract_date = $respService["data"][$x]["contract_date"];
    $renewal_date = $respService["data"][$x]["renewal_date"];
    $contract_id = $respService["data"][$x]["contract_id"];

    if($licenseRequired == 1){
    $sqlCount = "SELECT count(*) license_count FROM assignment WHERE sid= $sid
                  AND req_license= 1";
    $sqlCountResult = mysqli_query($conn,$sqlCount);
    $sqlCountArray = mysqli_fetch_assoc($sqlCountResult);
    $noLicensesUsed = $sqlCountArray['license_count'];
    $licenses_left = $max_license - $noLicensesUsed;
  }else{
    $licenses_left = "N/A";
  }

    $tpl->setCurrentBlock("TABLE_SERVICE");
    $tpl->setVariable("TBL_SERVICE_ID", $sid);
    $tpl->setVariable("NAME", $service_name);
    $tpl->setVariable("SID_SERVICE_TABLE", $sid);
    $tpl->setVariable("NO_LICENSE", $licenses_left);
    $tpl->setVariable("TABLE_SERVICE_NAME", $service_name);
    $tpl->setVariable("SERVICE_UPDATE_ID", $sid);
    if($licenses_left != "N/A" && $licenses_left > 0 && $licenses_left <= 5){
      $tpl->setVariable("NOTIFICATION_CLASS", "warning");
    }
    if($licenses_left == 0 && $licenseRequired != 0){
      $tpl->setVariable("NOTIFICATION_CLASS", "danger");
    }
    $tpl->parseCurrentBlock();

    $tpl->setCurrentBlock("MODALSERVICEUPDATE");
    $tpl->setVariable("UPDATE_SID", $sid);
    $tpl->setVariable("SID_UPDATE", $sid);
    $tpl->setVariable("CURRENT_SERVICE_NAME", $service_name);
    $tpl->setVariable("CURRENT_DESCRIPTION", $description);
    $tpl->setVariable("CURRENT_INT_CONTACT_NAME", $icn);
    $tpl->setVariable("CURRENT_INT_CONTACT_EMAIL", $ice);
    $tpl->setVariable("CURRENT_INT_CONTACT_PHONE", $icp);
    $tpl->setVariable("CURRENT_EXT_CONTACT_NAME", $ecn);
    $tpl->setVariable("CURRENT_EXT_CONTACT_EMAIL", $ece);
    $tpl->setVariable("CURRENT_EXT_CONTACT_PHONE", $ecp);
    $tpl->setVariable("CURRENT_COST", $cost);
    $tpl->setVariable("CURRENT_URL", $url);
    $tpl->setVariable("CURRENT_NO_LICENSE", $max_license);
    $tpl->setVariable("CURRENT_COST_UNIT", $cost_unit);
    $tpl->setVariable("CURRENT_CONTRACT_DATE", $contract_date);
    $tpl->setVariable("CURRENT_RENEWAL_DATE", $renewal_date);
    $tpl->setVariable("CURRENT_ID", $contract_id);
    $tpl->parseCurrentBlock();

    $tpl->setCurrentBlock("MODALASSIGN");
    $tpl->setVariable("SELECTION_BOX_REQ_LICENSE", $licenses_left);
    $tpl->parseCurrentBlock();

  }
}

/*** ADD ASSIGNMENT MODAL***/
$url = "http://localhost:8888/rollins/services/service-service.php";
$myvars = "action=get";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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


/*** ADD SERVICE MODAL ***/
$tpl->touchBlock("MODALSERVICE");


$tpl->show();
 ?>
