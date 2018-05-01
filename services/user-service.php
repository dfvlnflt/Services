<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include ('../includes/db-connect.php');

  //PULL ACTION FROM URL
  $action = $_POST['action'];

  switch($action)
  {
    case 'insert':

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $jobTitle = $_POST['jobTitle'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $response = array();
        $response['code'] = 0;
        $response['message'] = "";

        $sql = "SELECT count(*) user_count FROM user WHERE username = '$username'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        $row = mysqli_fetch_assoc($res);
        if($row['user_count'] >= 1){
          $response['code'] = 500;
          $response['message'] =  "Username is already taken.";
        }else{
          $sql = "INSERT INTO user (first_name, last_name, job_jobTitle, email, username, password)
                    VALUES ('$firstName','$lastName', '$jobTitle', '$email', '$username', sha1('$password'))";
          $result = mysqli_query($conn,$sql);
          /*if ($result)
            header('Location: ../login.php');
          else {
            echo "ERROR";
          }*/
          $response['message'] = "success";
        }
        echo json_encode($response);

    break;
    case 'update':
      //CODE TO MODIFY USER
      $firstName = $_GET['firstName'];
      $lastName = $_GET['lastName'];
      $jobTitle = $_GET['jobTitle'];
      $email = $_GET['email'];
      $username = $_GET['username'];

      echo '<strong> Update: </strong>';

      $sqlCheck = "SELECT count(*) user_count FROM user WHERE username = '$username'";
      $resCheck = mysqli_query($conn, $sqlCheck) or die (mysqli_error($conn));
      $rowCheck = mysqli_fetch_assoc($resCheck);
      if($rowCheck['user_count'] == 0){
        echo"User not found";
      }else{
        $sql = "UPDATE user SET first_name = '$firstName', last_name = '$lastName', job_jobTitle = '$jobTitle', email = '$email'
                WHERE username = '$username'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        echo "SUCCESS";
      }

    break;
    case 'delete':
      //CODE TO DELETE USER
      $username = $_GET['username'];
      echo '<strong> DELETE: </strong>';

      $sqlCheck = "SELECT count(*) user_count FROM user WHERE username = '$username'";
      $resCheck = mysqli_query($conn, $sqlCheck) or die (mysqli_error($conn));
      $rowCheck = mysqli_fetch_assoc($resCheck);
      if($rowCheck['user_count'] == 0){
        echo"USER NOT FOUND";
      }else{
        $sql = "DELETE FROM user WHERE username = '$username'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        echo "SUCCESS";
      }
    break;
    case 'get':
      //CODE TO SELECT USER
      $username = $_GET['username'];
      echo '<strong> GET: </strong>';

      $sqlCheck = "SELECT count(*) user_count FROM user WHERE username = '$username'";
      $resCheck = mysqli_query($conn, $sqlCheck) or die (mysqli_error($conn));
      $rowCheck = mysqli_fetch_assoc($resCheck);
      if($rowCheck['user_count'] == 0){
        echo"USER NOT FOUND";
      }else{
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        while($row = mysqli_fetch_assoc($res)){
          echo($row["first_name"]);
        }
     }

    break;
    case 'verify':
      //CODE TO VERIFY LOGIN INFORMATION
      $username = $_POST['username'];
      $password = $_POST['password'];
      $response = array();
      $response['code'] = 0;
      $response['message'] = "";
      //echo '<strong> VERIFY: </strong>';

      $sql = "SELECT count(*) user_count FROM user WHERE username = '$username' AND password =sha1('$password')";
      $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
      $row = mysqli_fetch_assoc($res);
      if($row['user_count'] == 0){
        $response['code'] = 500;
        $response['message'] = "Invalid Login Credentials";
        //header('Location: ../login.php');
      }else{
        $response['message'] = "success";
        //header('Location: ../home.php');
      }
      echo json_encode($response);
    break;
    default:
      //IF A VALID ACTION WAS NOT REQUESTED, SEND AN ERROR
      echo "Invalid Request";
    break;
  }

 ?>
