<?php
session_start();
include ('includes/db-connect.php');

/*** LOAD TEMPLATE ***/
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();
$tpl->loadTemplatefile('templates/home.tpl.htm', true, true);


/*** LOAD BUTTONS AND LOGO***/
$tpl->touchBlock("LOGO");
$tpl->setCurrentBlock("BUTTONS");
$tpl->setVariable("USER_FIRST_NAME", $user_first_name);
$tpl->parseCurrentBlock();




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


    $sqlCount = "SELECT count(*) license_count FROM assignment WHERE sid= $sid
                AND req_license= 1";
    $sqlCountResult = mysqli_query($conn,$sqlCount);
    $sqlCountArray = mysqli_fetch_assoc($sqlCountResult);
    $noLicensesUsed = $sqlCountArray['license_count'];
    $licenses_left = $max_license - $noLicensesUsed;


    $tpl->setCurrentBlock("TABLE_SERVICE");
    $tpl->setVariable("TBL_SERVICE_ID", $sid);
    $tpl->setVariable("NAME", $service_name);
    $tpl->setVariable("SID_SERVICE_TABLE", $sid);
    $tpl->setVariable("NO_LICENSE", $licenses_left);
    $tpl->setVariable("TABLE_SERVICE_NAME", $service_name);
    $tpl->setVariable("SERVICE_UPDATE_ID", $sid);
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
$tpl->touchBlock("MODALASSIGN");
$tpl->touchBlock("MODALSERVICE");


$tpl->show();
 ?>



 <!Doctype html>
 <html>
   <head>
     <style>

     .astext {
     background:none;
     border:none;
     margin:0;
     padding:0;
     }
     .center {
         display: block;
         margin-left: auto;
         margin-right: auto;

     }
     .notbold{
     font-weight:normal;
 }​
     hr {
       display: block;
       margin-top: 0.5em;
       margin-bottom: 0.5em;
       margin-left: auto;
       margin-right: auto;
       border-style: inset;
       border-width: 2px;
     }

     table {
     margin-left: 20px;
     font-family: arial, sans-serif;
     border-collapse: collapse;
     width: 100%;
     }

     td, th {
       border: 1px solid #dddddd;
       text-align: left;
       padding: 8px;
     }

     tr:nth-child(even) {
       background-color: #dddddd;
     }

     .buttonF{
       float: left;
     }

     .button4 {
       padding: 3px 5px;
     color: black;
     border: 2px solid #e7e7e7;
 }

 .button4:hover {background-color: #e7e7e7;}



     </style>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
     <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
   </head>
   <body>
     <!-- BEGIN LOGO -->
     <div id="pg_header_logo">
             <a href="http://www.rollins.edu/">
               <img alt="Rollins College Home" src="https://bannerweb.rollins.edu/rollinsdocs/images/rollins.png" title="Rollins College Home" class ="center">
             </a>
    </div>
    <hr>
    <!-- END LOGO -->

    <!-- BEGIN BUTTONS -->
    <div class="container">
      <div class="btn-group">
        <p>{USER_FIRST_NAME}</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalService">Add Service</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalAssign">Add Assignment</button>
        <button type="button" class="btn btn-primary" onclick="window.location='login.php'">Logout</button>
      </div>
    </div>
    <!-- END BUTTONS -->
    <div class= "container" >
    <h1>Assignments: </h1>
    <input class="form-control" id="myInput" type="text" placeholder="Search ID's, services, usernames, or justifications.."><br>

       <table class="table table-bordered table-striped table-hover container" id="example" >
         <thead>
         <tr>
           <th><strong>ID</strong></th>
           <th><strong>Service</strong></th>
           <th><strong>User</strong></th>
           <th><strong>Justification</strong></th>
           <th></th>
         </tr>
       </thead>
         <!-- BEGIN TABLE -->
         <tbody id="myTableAssignment">
           <tr>
             <td>{AID}</td>
             <td><button class="astext button4" data-toggle="modal" data-target="#myModal{TBL_SERVICE_ID}">{SERVICE_NAME}</button></td>
             <td>{BANN_NTID}</td>
             <td>{JUSTIFICATION}</td>
             <td>
                 <form action='services/assignment-service.php' method="POST">
                   <input type="hidden" name="action" value="delete">
                   <input type="hidden" name="aid" value="{AID}" />
                   <button class="btn btn-primary buttonF" type="submit" name="submit"><span class="glyphicon glyphicon-trash"></span></button>
                 </form>
                 <button class= "btn btn-primary buttonF" data-toggle="modal" data-target="#myModalAssignUpdate{ASSINGMENT_UPDATE_ID}"><span class="glyphicon glyphicon-pencil"></span></button>
             </td>
           </tr>
         </tbody>
         <!-- END TABLE -->
       </table>

         <!-- BEGIN MODAL -->
         <div class="modal fade" id="myModal{SERVICE_ID}" role="dialog">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Service Description</h4>
               </div>
               <div class="modal-body">
                 <p>Name: {SERVICE_NAME_MODAL}</p>
                 <p>Service ID: {SERVICE_SID_MODAL}</p>
                 <p>Description: {SERVICE_DESCRIPTION_MODAL}</p>
                 <p>URL: {SERVICE_URL_MODAL}</p>
                 <p>External Contact Name: {SERVICE_ECN_MODAL}</p>
                 <p>External Contact Phone: {SERVICE_ECP_MODAL}</p>
                 <p>External Contact Email: {SERVICE_ECE_MODAL}</p>
                 <p>Number of Licenses: {SERVICE_NO_LICENSE_MODAL}</p>
                 <p>Internal Contact Name: {SERVICE_ICN_MODAL}</p>
                 <p>Internal Contact Phone: {SERVICE_ICP_MODAL}</p>
                 <p>Internal Contact Email: {SERVICE_ICE_MODAL}</p>
                 <p>Cost: {SERVICE_COST_MODAL}</p>
                 <p>Cost per Unit: {SERVICE_COST_UNIT_MODAL}</p>
                 <p>Contract Date: {SERVICE_CONTRACT_DATE_MODAL}</p>
                 <p>Renewal Date: {SERVICE_RENEWAL_DATE_MODAL}</p>
                 <p>Contract ID: {SERVICE_CONTRACT_ID_MODAL}</p>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
             </div>

           </div>
         </div>
         <!-- END MODAL -->


         <!-- BEGIN MODALASSIGN -->
         <div class="modal fade" id="myModalAssign" role="dialog">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Add Assignment</h4>
               </div>
               <div class="modal-body">
                 <form action="services/assignment-service.php" method="POST">
                   <input type="hidden" name="action" value="insert" />
                 <div class="container">
                 </form>
                 <strong>Select a Service: </strong>
                 <select name='service'>
                   <option value="0" selected>&nbsp;</option>
                   <!-- BEGIN SELECTION_BOX -->
                   <option value='{SERVICE_ID}'>{SERVICE_NAME}</option>
                   <!-- END SELECTION_BOX -->
                 </select>

                 <br><strong>FoxID: </strong><br>
                 <div class="form-group">
                   <input type="text"  name='bann_ntid'placeholder="Enter FoxID">
                 </div>

                 <strong>Justification: </strong><br>
                 <div class="form-group">
                   <textarea class="textarea" name="justification" placeholder="Enter Justification" rows="4" cols="50" required></textarea>
                   <span class="error">*</span>
                   <br>
                 </div>

                 <strong>License required? </strong> <br>
                 <input type="radio" name="req_license" value="1"> Yes<br>
                 <input type="radio" name="req_license" value="0"> No<br>

                 <button type="submit" class="btn btn-default">Submit</button>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
             </div>

           </div>
         </div>
         </div>
         <!-- END MODALASSIGN -->



 <div class = "container">
   <h1> Services: </h1>
   <input class="form-control" id="myInputServices" type="text" placeholder="Search.."><br>
 </div>

    <table class="table table-bordered table-striped" name='services' id="example2">
      <thead>
      <tr>
        <th><strong>Service ID</strong></th>
        <th><strong>Service Name</strong></th>
        <th><strong>Number of Available License</strong></th>
        <th></th>
      </tr>
    </thead>
    <!-- BEGIN TABLE_SERVICE -->
    <tbody id="myTableServices">
        <td>{SID_SERVICE_TABLE}</td>
        <td><button class="astext button4" data-toggle="modal" data-target="#myModal{TBL_SERVICE_ID}">{TABLE_SERVICE_NAME}</button></td>
        <td>{NO_LICENSE}</td>
        <td class="contact-delete">
            <form action='services/service-service.php' method="POST">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="name" value="{NAME}" />
              <button class="btn btn-primary buttonF" type="submit" name="submit"><span class="glyphicon glyphicon-trash"></span></button>
            </form>
            <button class= "btn btn-primary buttonF" data-toggle="modal" data-target="#myModalServiceUpdate{SERVICE_UPDATE_ID}"><span class="glyphicon glyphicon-pencil"></span></button>
        </td>
      </tr>
      <tbody>
    <!-- END TABLE_SERVICE -->
    </table>


    <!-- BEGIN MODALSERVICE -->
    <div class="modal fade" id="myModalService" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Service</h4>
          </div>
          <div class="modal-body">
            <form action="services/service-service.php" method="POST">
              <input type="hidden" name="action" value="insert" />
              <fieldset>

                <strong>Name of Service:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="Name of service" required>
                </div>

                <strong>Description:</strong><br>
                <div class="form-group">
                <textarea class="form-control textarea"name="description" placeholder="Description" required></textarea>
                </div>

                <strong>Internal Contact Name:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="int_contact_name" placeholder="Name" required>
                </div>

                <strong>Internal Contact Email:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="int_contact_email" placeholder="Email" required>
                </div>

                <strong>Internal Contact Phone:</strong><br>
                <div class="form-group">
                <input class= "form-control" type="text" name="int_contact_phone" placeholder="Phone Number" required>
              </div>

                <strong> URL:</strong><br>
                <div class="form-group">
                <input class= "form-control" type="text" name="url" placeholder="URL">
              </div>

                <strong>External Contact Name:</strong><br>
                <div class="form-group">
                <input class= "form-control" type="text" name="ext_contact_name" placeholder="Name">
              </div>

                <strong>External Contact Email:<strong><br>
                <div class="form-group">
                <input class= "form-control" type="text" name="ext_contact_email" placeholder="Email">
              </div>

                <strong>External Contact Phone:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="ext_contact_phone" placeholder="Phone">
              </div>

                <strong>Number of Licenses:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="no_license" placeholder="Number of Licenses (Please enter '0' if no licenses required)">
              </div>

                <strong>Cost:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="cost" placeholder="Cost">
              </div>

                <strong>Cost per Unit:</strong><br>
                <div class="form-group">
                <input class="form-control" type="text" name="cost_unit" placeholder="Cost per Unit">
              </div>

                <strong>Contract Date:</strong<br>
                <div class="form-group">
                <input class="form-control" type="date" name="contract_date">
              </div>

                <strong>Contract Renewal:</strong><br>
                <div class="form-group">
                <input class="form-control" type="date" name="renewal_date">
              </div>

                <strong>Contract ID:<strong><br>
                <div class="form-group">
                <input type="text" name="contract_id" placeholder="ID">
              </div>

                <button type="submit" class="btn btn-default">Submit</button>
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <!-- END MODALSERVICE -->




    <!-- BEGIN MODALASSIGNUPDATE -->
    <div class="modal fade" id="myModalAssignUpdate{UPDATE_AID}" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Update Assignment</h4>
          </div>
          <div class="modal-body">
            <form action="services/assignment-service.php" method="POST">
              <input type="hidden" name="action" value="update" />
              <input type="hidden" name='aid' value={AID_UPDATE} />

            <strong>FoxID: </strong><br>
            <div class="form-group">
              <input class= "form-control notbold" type="text"  name='bann_ntid'placeholder="{CURRENT_BANN_NTID}">
            </div>

            <strong>Justification: </strong><br>
            <div class="form-group">
              <textarea class="textarea notbold form-control" name="justification" placeholder="{CURRENT_JUSTIFICATION}" rows="4" cols="50"></textarea>
              <br>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
            </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    </div>
    <!-- END MODALASSIGNUPDATE -->




    <!-- BEGIN MODALSERVICEUPDATE -->
    <div class="modal fade" id="myModalServiceUpdate{UPDATE_SID}" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Update Service</h4>
          </div>
          <div class="modal-body">
            <form action="services/service-service.php" method="POST">
              <input type="hidden" name="action" value="update" />
              <input type="hidden" name='sid' value={SID_UPDATE} />

              <strong>Name of Service:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="name" placeholder="{CURRENT_SERVICE_NAME}">
              </div>

              <strong>Description:</strong><br>
              <div class="form-group">
              <textarea class="form-control textarea notbold"name="description" placeholder="{CURRENT_DESCRIPTION}"></textarea>
              </div>

              <strong>Internal Contact Name:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="int_contact_name" placeholder="{CURRENT_INT_CONTACT_NAME}">
              </div>

              <strong>Internal Contact Email:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="int_contact_email" placeholder="{CURRENT_INT_CONTACT_EMAIL}">
              </div>

              <strong>Internal Contact Phone:</strong><br>
              <div class="form-group">
              <input class= "form-control notbold" type="text" name="int_contact_phone" placeholder="{CURRENT_INT_CONTACT_PHONE}">
            </div>

              <strong> URL:</strong><br>
              <div class="form-group">
              <input class= "form-control notbold" type="text" name="url" placeholder="{CURRENT_URL}">
            </div>

              <strong>External Contact Name:</strong><br>
              <div class="form-group">
              <input class= "form-control notbold" type="text" name="ext_contact_name" placeholder="{CURRENT_EXT_CONTACT_NAME}">
            </div>

              <strong>External Contact Email:</strong><br>
              <div class="form-group">
              <input class= "form-control notbold" type="text" name="ext_contact_email" placeholder="{CURRENT_EXT_CONTACT_EMAIL}">
            </div>

              <strong>External Contact Phone:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="ext_contact_phone" placeholder="{CURRENT_EXT_CONTACT_PHONE}">
            </div>

              <strong>Number of Licenses:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="no_license" placeholder="{CURRENT_NO_LICENSE}">
            </div>

              <strong>Cost:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="cost" placeholder="{CURRENT_COST}">
            </div>

              <strong>Cost per Unit:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="text" name="cost_unit" placeholder="{CURRENT_COST_UNIT}">
            </div>

              <strong>Contract Date:</strong<br>
              <div class="form-group">
              <input class="form-control notbold" type="date" name="{CURRENT_CONTRACT_DATE}">
            </div>

              <strong>Contract Renewal:</strong><br>
              <div class="form-group">
              <input class="form-control notbold" type="date" name="{CURRENT_RENEWAL_DATE}">
            </div>

              <strong>Contract ID:</strong><br>
              <div class="form-group">
              <input type="text notbold" name="contract_id" placeholder="{CURRENT_ID}">
            </div>

              <button type="submit" class="btn btn-default">Submit</button>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>

      </div>
    </div>
    </div>
    <!-- END MODALSERVICEUPDATE -->






    <script>
       $(document).ready(function(){
         $("#myInput").on("keyup", function() {
           var value = $(this).val().toLowerCase();
           $("#myTableAssignment tr").filter(function() {
             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
           });
         });
       });
     </script>

     <script>
        $(document).ready(function(){
          $("#myInputServices").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableServices tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
      </script>

      <script>
      $(document).ready(function() {
     $('#example').DataTable( {
         scrollY:        '10vh',
         scrollCollapse: true,
         paging:         false,
         searching: false,
         bInfo: false


     } );
 } );
      </script>

      <script>
      $(document).ready(function() {
      $('#example2').DataTable( {
         scrollY:        '10vh',
         scrollCollapse: true,
         paging:         false,
         searching: false,
         bInfo: false


      } );
      } );
      </script>




   </body>
 </html>
