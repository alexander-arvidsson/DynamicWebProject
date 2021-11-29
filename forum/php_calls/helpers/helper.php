<?php
require 'checker.php';
require 'commons.php';

$stmt = $db -> prepare("SELECT * FROM USER WHERE userName = :userName OR email = :email");
$stmt -> bindParam('userName', $name, SQLITE3_TEXT);
$stmt -> bindParam('email', $email, SQLITE3_TEXT);
$result = $stmt -> execute();

if(!rowCount($result) == 0) {
$users = array();
$i = 0;
while($arr = $result -> fetchArray(SQLITE3_ASSOC)) {
    $users['userName'] = $arr['userName'];
    $users['email'] = $arr['email'];
}

if ($name == $users['userName']) {
    echo json_encode(array("status" => "Name_Taken"));
    exit();
} else {
    echo json_encode(array("status" => "Email_Taken"));
    exit();
} 
}

?>