<?php
session_start();
if (!isset($_SESSION['userId']) || !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
}
    
require 'helpers/update_check.php';

if ($nCheck == 'None' && $eCheck == 'None' && $pCheck == 'None') {
    echo json_encode(array('Ok'), JSON_FORCE_OBJECT);
} else {
    $arr = array($nCheck, $eCheck, $pCheck);

        if($arr[0] == 'Ok') {
            upDate($db, 'userName', $name);
        }
        if($arr[1] == 'Ok') {
            upDate($db, 'email', $email);
        }
        if($arr[2] == 'Ok') {
            upDate($db, 'password', $pass);
        }
    }
    echo json_encode($arr, JSON_FORCE_OBJECT);

    function upDate($db, $column, $var) {
        $stmt = $db->prepare("UPDATE USER SET $column = :up WHERE id = :userId");
        $stmt->bindParam('up', $var, SQLITE3_TEXT);
        $stmt->bindParam('userId', $_SESSION['userId'], SQLITE3_TEXT);
        $stmt->execute();
    }

?>