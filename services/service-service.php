<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include ('../includes/db-connect.php');

  //PULL ACTION FROM URL
  $action = $_POST['action'];

  switch($action)
  {
    case 'insert':
      $description = $_POST['description'];
      $name = $_POST['name'];
      $url = $_POST['url'];
      $ext_contact_name = $_POST['ext_contact_name'];
      $ext_contact_email = $_POST['ext_contact_email'];
      $ext_contact_phone = $_POST['ext_contact_phone'];
      $licenseRequired = $_POST['licenseRequired'];
      $no_license = $_POST['no_license'];
      $int_contact_name = $_POST['int_contact_name'];
      $int_contact_email = $_POST['int_contact_email'];
      $int_contact_phone = $_POST['int_contact_phone'];
      $cost = $_POST['cost'];
      $cost_unit = $_POST['cost_unit'];
      $contract_date = $_POST['contract_date'];
      $renewal_date = $_POST['renewal_date'];
      $contract_id = $_POST['contract_id'];

      $response = array();
      $response['code'] = 0;
      $response['message'] = "";

      $sql = "SELECT count(*) service_count FROM services WHERE name = '$name'";
      $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
      $row = mysqli_fetch_assoc($res);
      if($row['service_count'] >= 1){
        $response['code'] = 500;
        $response['message'] =  "Service name is already taken.";
      }else{
        $sql = "INSERT INTO services (description, name, url, ext_contact_name, ext_contact_email, ext_contact_phone, licenseRequired,
                no_license, int_contact_name,int_contact_email, int_contact_phone, cost, cost_unit, contract_date,
                renewal_date, contract_id)
                VALUES ('$description', '$name', '$url', '$ext_contact_name', '$ext_contact_email', '$ext_contact_phone', '$licenseRequired',
                        '$no_license', '$int_contact_name', '$int_contact_email', '$int_contact_phone', '$cost', '$cost_unit', '$contract_date',
                        '$renewal_date', '$contract_id')";
        $result = mysqli_query($conn,$sql);
        /*if ($result)
          //echo "SUCCESS";
          header('Location: ../home.php');
        else {
          echo "ERROR";
        }*/
        $response['message'] = "success";
      }
    echo json_encode($response);

    break;
    case 'update':

    $sid= $_POST['sid'];
    $description = $_POST['description'];
    $name = $_POST['name'];
    $url = $_POST['url'];
    $ext_contact_name = $_POST['ext_contact_name'];
    $ext_contact_email = $_POST['ext_contact_email'];
    $ext_contact_phone = $_POST['ext_contact_phone'];
    $licenseRequired = $_POST['licenseRequired'];
    $no_license = $_POST['no_license'];
    $int_contact_name = $_POST['int_contact_name'];
    $int_contact_email = $_POST['int_contact_email'];
    $int_contact_phone = $_POST['int_contact_phone'];
    $cost = $_POST['cost'];
    $cost_unit = $_POST['cost_unit'];
    $contract_date = $_POST['contract_date'];
    $renewal_date = $_POST['renewal_date'];
    $contract_id = $_POST['contract_id'];

    $sql = "UPDATE services SET name=";
    if ($name == "")
    {
      $sql .= "name,";
    }
    else
    {
      $sql .= "'$name',";
    }
    $sql .= "description=";
    if ($description == "")
    {
      $sql .= "description,";
    }
    else {
      $sql .= "'$description',";
    }
    $sql .= "url=";
    if ($url == "")
    {
      $sql .= "url,";
    }
    else {
      $sql .= "'$url',";
    }
    $sql .= "ext_contact_name=";
    if ($ext_contact_name == "")
    {
      $sql .= "ext_contact_name,";
    }
    else {
      $sql .= "'$ext_contact_name',";
    }
    $sql .= "ext_contact_email=";
    if ($ext_contact_email == "")
    {
      $sql .= "ext_contact_email,";
    }
    else {
      $sql .= "'$ext_contact_email',";
    }
    $sql .= "ext_contact_phone=";
    if ($ext_contact_phone == "")
    {
      $sql .= "ext_contact_phone,";
    }
    else {
      $sql .= "'$ext_contact_phone',";
    }
    $sql .= "licenseRequired=";
    if ($licenseRequired == "")
    {
      $sql .= "licenseRequired,";
    }
    else {
      $sql .= "'$licenseRequired',";
    }
    $sql .= "no_license=";
    if ($no_license == "")
    {
      $sql .= "no_license,";
    }
    else {
      $sql .= "'$no_license',";
    }
    $sql .= "int_contact_name=";
    if ($int_contact_name == "")
    {
      $sql .= "int_contact_name,";
    }
    else {
      $sql .= "'$int_contact_name',";
    }
    $sql .= "int_contact_email=";
    if ($int_contact_email == "")
    {
      $sql .= "int_contact_email,";
    }
    else {
      $sql .= "'$int_contact_email',";
    }
    $sql .= "int_contact_phone=";
    if ($int_contact_phone == "")
    {
      $sql .= "int_contact_phone,";
    }
    else {
      $sql .= "'$int_contact_phone',";
    }
    $sql .= "cost=";
    if ($cost == "")
    {
      $sql .= "cost,";
    }
    else {
      $sql .= "'$cost',";
    }
    $sql .= "cost_unit=";
    if ($cost_unit == "")
    {
      $sql .= "cost_unit,";
    }
    else {
      $sql .= "'$cost_unit',";
    }
    $sql .= "contract_date=";
    if ($contract_date == "")
    {
      $sql .= "contract_date,";
    }
    else {
      $sql .= "'$contract_date',";
    }
    $sql .= "renewal_date=";
    if ($renewal_date == "")
    {
      $sql .= "renewal_date,";
    }
    else {
      $sql .= "'$renewal_date',";
    }
    $sql .= "contract_id=";
    if ($contract_id == "")
    {
      $sql .= "contract_id";
    }
    else {
      $sql .= "'$contract_id'";
    }

    $sql .= " WHERE sid = '$sid'";

    $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
    header('Location: ../home.php');

    break;
    case 'delete':
      //CODE TO DELETE SERVICE
      $name = $_POST['name'];
      echo '<strong> DELETE: </strong>';

      $sqlCheck = "SELECT count(*) service_count FROM services WHERE name = '$name'";
      $resCheck = mysqli_query($conn, $sqlCheck) or die (mysqli_error($conn));
      $rowCheck = mysqli_fetch_assoc($resCheck);
      if($rowCheck['service_count'] == 0){
        echo"SERVICE NOT FOUND";
      }else{
        $sql = "DELETE FROM services WHERE name = '$name'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        header('Location: ../home.php');
      }
    break;

    case 'get':
      //CODE TO SELECT SERVICE
      //echo '<strong> GET: </strong>';

      $returnArr = array();
      $returnArr['data'] = array();
      $dataArr = array();
      $responseCode = "202";
      if (isset($_POST['id']))
      {
        $id = $_POST['id'];
        $sql = "SELECT sid, description, name, url, ext_contact_name, ext_contact_email, ext_contact_phone, licenseRequired, no_license, int_contact_name, int_contact_email, int_contact_phone, cost, cost_unit, contract_date, renewal_date, contract_id FROM services WHERE sid = $id ORDER BY name";

      }
      else {
        $sql = "SELECT sid, description, name, url, ext_contact_name, ext_contact_email, ext_contact_phone, licenseRequired, no_license, int_contact_name, int_contact_email, int_contact_phone, cost, cost_unit, contract_date, renewal_date, contract_id FROM services ORDER BY name";
      }
      $res = mysqli_query($conn, $sql);
      $ct = 0;
      while ($row = mysqli_fetch_array($res)){
        $dataArr['sid'] = $row['sid'];
        $dataArr['description'] = $row['description'];
        $dataArr['name'] = $row['name'];
        $dataArr['url'] = $row['url'];
        $dataArr['ext_contact_name'] = $row['ext_contact_name'];
        $dataArr['ext_contact_email'] = $row['ext_contact_email'];
        $dataArr['ext_contact_phone'] = $row['ext_contact_phone'];
        $dataArr['licenseRequired'] = $row['licenseRequired'];
        $dataArr['no_license'] = $row['no_license'];
        $dataArr['int_contact_name'] = $row['int_contact_name'];
        $dataArr['int_contact_email'] = $row['int_contact_email'];
        $dataArr['int_contact_phone'] = $row['int_contact_phone'];
        $dataArr['cost'] = $row['cost'];
        $dataArr['cost_unit'] = $row['cost_unit'];
        $dataArr['contract_date'] = $row['contract_date'];
        $dataArr['renewal_date'] = $row['renewal_date'];
        $dataArr['contract_id'] = $row['contract_id'];

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
      echo "Invalid Request";
      break;
  }

 ?>
