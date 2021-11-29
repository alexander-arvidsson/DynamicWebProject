<?php
session_start();

 if(!isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ../index.php");
    exit();
}

require 'helpers/commons.php';

$uname = $email = '';
$password = $_POST['psw'];

if (isset($password)) {
    if (filter_var($_POST['uname'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['uname'];
    } else {
        $uname = $_POST['uname'];
    }

    if (empty($email)) {
        $stmt = $db->prepare("SELECT * FROM USER WHERE userName = :userName");
        $stmt->bindValue('userName', $uname, SQLITE3_TEXT);

        $result = $stmt->execute();
        getUsers($result, $password);
    } else if (empty($uname)) {
        $stmt = $db->prepare("SELECT * FROM USER WHERE email = :email");
        $stmt->bindValue('email', $email, SQLITE3_TEXT);

        $result = $stmt->execute();
        getUsers($result, $password);
    } else {
        echo  json_encode(array("status" => "Us_Error"));
    }
} else {
    echo  json_encode(array("status" => "Pass_Error"));
}

function getUsers($result, $password)
{
    if (rowCount($result) == 0) {
        echo  json_encode(array("status" => "Error"));
    } else {
        $users = array();
        $i = 0;
        while ($arr = $result->fetchArray(SQLITE3_ASSOC)) {
            $users['password'] = $arr['password'];
            $users['id'] = $arr['id'];
            $i++;
        }
        if (password_verify($password, $users['password'])) {
            $userId = $users['id'];
            $_SESSION['userId'] = $userId;
            echo  json_encode(array("status" => "Ok"));
        } else {
            echo  json_encode(array("status" => "Error"));
        }
    }
}

?>