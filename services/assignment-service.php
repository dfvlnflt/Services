<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include ('../includes/db-connect.php');

  //PULL ACTION FROM URL
  $action = $_POST['action'];

  switch($action)
  {
    case 'insert':
      $bann_ntid = $_POST['bann_ntid'];
      $sid = $_POST['service'];

      $sqlLicenses = "SELECT licenseRequired FROM services WHERE sid = $sid";
      $sqlLicensesResult = mysqli_query($conn,$sqlLicenses);
      $rowCheck = mysqli_fetch_assoc($sqlLicensesResult);
      if($rowCheck['licenseRequired'] == 1){
        $req_license = 1;
      }else{
        $req_license = 0;
      }

      $justification = $_POST['justification'];
      $updt_flag = 0;
      $is_archived = 0;

      $sql = "INSERT INTO assignment (sid, bann_ntid, justification, req_license, updt_flag, is_archived)
              VALUES ( '$sid', '$bann_ntid','$justification', '$req_license', '$updt_flag', '$is_archived')";
      //$sqlUpdate = "UPDATE services SET no_license= no_license-1 WHERE sid= '$sid'";
      $result = mysqli_query($conn,$sql);
      //$resultUpdate = mysqli_query($conn,$sqlUpdate);

      /*$sqlNo = "SELECT no_license FROM services WHERE sid = '$sid'";
      $resultUpdate = mysqli_query($conn,$sqlNo);
      if($resultUpdate < 0){

      }*/

      echo '<strong> INSERT: </strong>';
      if ($result)
        header('Location: ../home.php');
      else {
        echo "ERROR";
      }
      break;

    case 'update':
      //CODE TO MODIFY ASSIGNMENT
      $aid= $_POST['aid'];
      $justification = $_POST['justification'];
      $bann_ntid = $_POST['bann_ntid'];

      $sql = "UPDATE assignment SET justification=";
      if ($justification == "")
      {
        $sql .= "justification,";
      }
      else
      {
        $sql .= "'$justification',";
      }
      $sql .= "bann_ntid=";
      if ($bann_ntid == "")
      {
        $sql .= "bann_ntid";
      }
      else {
        $sql .= "'$bann_ntid'";
      }
      $sql .= " WHERE aid = '$aid'";


      $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
      header('Location: ../home.php');

    break;
    case 'delete':
      //CODE TO DELETE USER
      $aid = $_POST['aid'];

      $sqlCheck = "SELECT count(*) assignment_count FROM assignment WHERE aid = '$aid'";
      $resCheck = mysqli_query($conn, $sqlCheck) or die (mysqli_error($conn));
      $rowCheck = mysqli_fetch_assoc($resCheck);
      if($rowCheck['assignment_count'] == 0){
        echo '<strong> DELETE: </strong>';
        echo"ASSIGNMENT NOT FOUND";
      }else{
        $sql = "DELETE FROM assignment WHERE aid = '$aid'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        header('Location: ../home.php');
      }

    break;
    case 'get':
      //CODE TO SELECT USER
      $returnArr = array();
      $returnArr['data'] = array();
      $dataArr = array();
      $responseCode = "202";
      $sql = "SELECT a.aid, a.sid, a.bann_ntid, a.justification, a.req_license, a.updt_flag, a.is_archived,
              b.name, b.description, b.url, b.ext_contact_name, b.ext_contact_email, b.ext_contact_phone,
              b.no_license, b.int_contact_name, b.int_contact_email, b.int_contact_phone, b.cost,
              b.cost_unit, b.contract_date, b.renewal_date, b.contract_id FROM assignment a, services b
              WHERE a.sid = b.sid ORDER BY aid DESC";
      $res = mysqli_query($conn, $sql);
      $ct = 0;
      while ($row = mysqli_fetch_array($res)){
        $dataArr['aid'] = $row['aid'];
        $dataArr['sid'] = $row['sid'];
        $dataArr['bann_ntid'] = $row['bann_ntid'];
        $dataArr['justification'] = $row['justification'];
        $dataArr['req_license'] = $row['req_license'];
        $dataArr['updt_flag'] = $row['updt_flag'];
        $dataArr['is_archived'] = $row['is_archived'];
        $dataArr['service_name'] = $row['name'];
        $dataArr['service_description'] = $row['description'];
        $dataArr['service_url'] = $row['url'];
        $dataArr['service_ecn'] = $row['ext_contact_name'];
        $dataArr['service_ecp'] = $row['ext_contact_phone'];
        $dataArr['service_ece'] = $row['ext_contact_email'];
        $dataArr['service_no_license'] = $row['no_license'];
        $dataArr['service_icn'] = $row['int_contact_name'];
        $dataArr['service_icp'] = $row['int_contact_phone'];
        $dataArr['service_ice'] = $row['int_contact_email'];
        $dataArr['service_cost'] = $row['cost'];
        $dataArr['service_cost_unit'] = $row['cost_unit'];
        $dataArr['service_contract_date'] = $row['contract_date'];
        $dataArr['service_renewal_date'] = $row['renewal_date'];
        $dataArr['service_contract_id'] = $row['contract_id'];


        array_push($returnArr['data'], $dataArr);
        $ct++;
      }
      if ($ct == 0)
      {
        $responseCode = "204";
      }
      else {
        $responseCode = "200";
      }
      $returnArr['responseCode'] = $responseCode;
      echo json_encode($returnArr);
    break;
    default:
      //IF A VALID ACTION WAS NOT REQUESTED, SEND AN ERROR
      echo "Invalid Request";
    break;
  }

 ?>
