<?php

if(!isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
    exit();
}

require 'helpers/commons.php';

$flag = $_POST['flag'];
$input = "%" . trim($_POST['input']) . "%";

$alt_a = "COMMENT.topic LIKE :input OR COMMENT.comment LIKE :input";
$alt_t = "Comment.topic LIKE :input";
$alt_c = "Comment.comment LIKE :input";

if (empty(trim($_POST['input'])) || strlen(trim($_POST['input'])) < 2) {
    echo json_encode(array("status" => "Error"));
} else {

    if ($flag == "a") {
        runSearch($db, $alt_a, $input);
    } elseif ($flag == "t") {
        runSearch($db, $alt_t, $input);
    } elseif ($flag == "c") {
        $result = runSearch($db, $alt_c, $input);
    } else {
        echo json_encode(array("status" => "Error"));
    }
}


function runSearch($db, $flag, $input)
{
    $stmt = $db->prepare("SELECT COMMENT.id, COMMENT.date, COMMENT.time, COMMENT.topic, COMMENT.comment, 
USER.userName, USER.profilePic FROM COMMENT 
INNER JOIN USER ON COMMENT.userId = USER.id WHERE $flag ORDER BY COMMENT.id DESC");
    $stmt->bindValue('input', $input, SQLITE3_TEXT);
    $result = $stmt->execute();

    if (rowCount($result) == 0) {
        echo json_encode(array("status" => "NotFound_Error"));
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
}
