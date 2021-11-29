<?php 
session_start();
if(!isset($_SESSION['userId']) || !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
}

require 'helpers/commons.php';

$stmt = $db->prepare("DELETE FROM COMMENT WHERE id = :commentId");
$stmt->bindParam('commentId', $_POST['commentId'], SQLITE3_TEXT);
$result = $stmt->execute();

if($result == false) {
    echo json_encode(array("status" => "NotFound_Error"));
    exit();
} else {
    echo json_encode(array("status" => "Ok"));
}

?>