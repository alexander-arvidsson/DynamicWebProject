<?php
require 'helpers/commons.php';

if(!isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
    exit();
}

if($_POST['offset'] == 0) {

$stmt = $db-> prepare("SELECT COMMENT.id, COMMENT.userId, COMMENT.date, COMMENT.time, COMMENT.topic, COMMENT.comment, 
USER.userName, USER.profilePic FROM COMMENT 
INNER JOIN USER ON COMMENT.userId = USER.id ORDER BY COMMENT.id DESC LIMIT :limit");
$stmt->bindValue('limit', $_POST['limit'], SQLITE3_TEXT);
$result = $stmt -> execute();

} elseif($_POST['limit'] == 1) {
$stmt = $db-> prepare("SELECT COMMENT.id, COMMENT.userId, COMMENT.date, COMMENT.time, COMMENT.topic, COMMENT.comment, 
USER.userName, USER.profilePic FROM COMMENT 
INNER JOIN USER ON COMMENT.userId = USER.id ORDER BY COMMENT.id DESC LIMIT :limit");
$stmt->bindValue('limit', $_POST['limit'], SQLITE3_TEXT);
$result = $stmt -> execute();

} else {
$stmt = $db-> prepare("SELECT COMMENT.id, COMMENT.userId, COMMENT.date, COMMENT.time, COMMENT.topic, COMMENT.comment,
USER.userName, USER.profilePic FROM COMMENT 
INNER JOIN USER ON COMMENT.userId = USER.id WHERE COMMENT.id <:id ORDER BY COMMENT.id DESC LIMIT :limit");
$stmt->bindValue('id', $_POST['offset'], SQLITE3_TEXT);
$stmt->bindValue('limit', $_POST['limit'], SQLITE3_TEXT);
$result = $stmt -> execute();

}

if(rowCount($result) == 0) {
    echo  json_encode(array("status" => "NotFound_Error"));
    exit();
} else {
    $comments = array();
    $i = 0;

    while ($arr = $result->fetchArray(SQLITE3_ASSOC)) {
        $comments[] = $arr;
        $i++;
    }

    echo json_encode($comments);
}

?>