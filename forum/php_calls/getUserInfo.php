<?php
session_start();
if (!isset($_SESSION['userId']) || !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
}

require 'helpers/commons.php';

$stmt = $db -> prepare("SELECT * FROM USER WHERE id = :userId");
$stmt -> bindParam('userId', $_SESSION['userId'], SQLITE3_TEXT);
$result = $stmt -> execute();

if(!rowCount($result) == 0) {
    $user = array();
    $i = 0;
    while($arr = $result -> fetchArray(SQLITE3_ASSOC)) {
        $user[] = $arr;
    }  
    echo json_encode($user);
 } else {
    echo json_encode(array("status" => "NotFound_Error"));
 }


?>