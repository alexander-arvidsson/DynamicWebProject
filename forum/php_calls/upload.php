<?php

session_start();
if(!isset($_SESSION['userId']) || !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
    exit();
}

require 'helpers/commons.php';

if (isset($_FILES['pic'])) {
    $tempname = $_FILES['pic']["tmp_name"];
    $type = getTypes($tempname);

    if ($type == 'error') {
        echo json_encode(array("status" => "File_Error"));
    } else {
        $filename = 'upr' . $_SESSION['userId'] . $type;
        $folder = '../img/' . $filename;
        $dbFolder = 'img/' . $filename;
        if (file_exists($folder)) {
            unlink($folder);
        }
        
        move_uploaded_file($tempname, $folder);

        $stmt = $db->prepare("UPDATE USER SET profilePic = :pic WHERE id = :userId");
        $stmt->bindParam('pic', $dbFolder, SQLITE3_TEXT);
        $stmt->bindParam('userId', $_SESSION['userId'], SQLITE3_TEXT);
        $result = $stmt->execute();

        echo json_encode(array("status" => "Ok"));

    }
} else {
    echo json_encode(array("status" => "Unknown_Error"));
}

function getTypes($filename) {
    $mime = mime_content_type($filename);

    if ($mime == 'image/png') {
        return ".png";
    } else if ($mime == 'image/jpeg') {
        return ".jpg";
    } else {
        return 'error';
    }
}
