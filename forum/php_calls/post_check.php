<?php
session_start();

 if(!isset($_SESSION['userId']) || !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
    exit();
}
require 'helpers/post_checker.php';
require 'helpers/commons.php';

$stmt = $db -> prepare("INSERT into 'COMMENT'('userId', 'time', 'date', 'topic', 'comment') 
VALUES (:userId, :time, :date, :topic, :comment)");
$stmt -> bindParam("userId", $_SESSION['userId'], SQLITE3_TEXT);
$stmt -> bindParam("time", $time, SQLITE3_TEXT);
$stmt -> bindParam("date", $date, SQLITE3_TEXT);
$stmt -> bindParam("topic", $topic, SQLITE3_TEXT);
$stmt -> bindParam("comment", $comment, SQLITE3_TEXT);

$result = $stmt -> execute();

if(!$result) {
echo json_encode(array("status" => "Error_NotPossible"));
exit();
} else {
    echo json_encode(array("status" => "Ok"));
}
