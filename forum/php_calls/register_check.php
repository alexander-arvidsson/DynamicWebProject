<?php
if(!isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
    exit();
}

require 'helpers/helper.php';

$password = $pass;
$passwordhash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db -> prepare("INSERT into 'USER'('userName', 'email', 'password'  ) 
VALUES (:userName, :email, :password)");
$stmt -> bindParam("userName", $name, SQLITE3_TEXT);
$stmt -> bindParam("email", $email, SQLITE3_TEXT);
$stmt -> bindParam("password", $passwordhash, SQLITE3_TEXT);
$result = $stmt -> execute();

if($result) {
    echo json_encode(array("status" => "Ok"));
    
} else {
    echo json_encode(array("status" => "Error_NotPossible"));
}
?>