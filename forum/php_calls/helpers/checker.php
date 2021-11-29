<?php
$emptyErr = $emailErr = '';
$name = $email = $pass = '';

  if(empty($_POST['uname'])) {
    $emptyErr = 'Name cannot be empty';
    echo json_encode(array("status" => "Error"));
    exit();
  } else {
    $name = $_POST['uname'];
  }
  
  if(empty($_POST['email'])) {
    $emptyErr = 'Email cannot be empty';
    echo json_encode(array("status" => "Error"));
    exit();
  } else {
    $email = test_input($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = 'Invalid Email format';
       echo json_encode(array("status" => "Error"));
      exit();
    } else {
      $email = test_input($_POST['email']);
    }

  if(empty($_POST['pass'])) {
    $emptyErr = 'Password cannot be empty';
    echo json_encode(array("status" => "Error"));
    exit();
  } else {
    $pass = $_POST['pass'];
  }
} 

function test_input($data) {
  $data = trim($data);
  return $data;
}

?>