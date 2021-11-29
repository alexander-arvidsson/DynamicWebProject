<?php
require 'commons.php';

$name = '';
$email = '';
$pass = '';

$pCheck = $eCheck = $nCheck = 'None';

if (!empty($_POST['uname']) || !empty($_POST['email'])) {
    $name = $_POST['uname'];
    $email = $_POST['email'];

    $stmt = $db->prepare("SELECT * FROM USER WHERE userName = :userName OR email = :email");
    $stmt->bindParam('userName', $name, SQLITE3_TEXT);
    $stmt->bindParam('email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();

    if (!rowCount($result) == 0) {
        $users = array();
        $i = 0;
        while ($arr = $result->fetchArray(SQLITE3_ASSOC)) {
            $users['userName'] = $arr['userName'];
            $users['email'] = $arr['email'];
        }
        if ($name == $users['userName']) {
            $nCheck = 'Name_Taken';
        }

        if ($email == $users['email']) {
            $eCheck = 'Email_Taken';
        }
    } else {
        if (!empty($name)) {
            $nCheck = 'Ok';
        }

        if (!empty($email)) {
            $eCheck = 'Ok';
        }
    }
}

if (!empty($_POST['olpass']) && !empty($_POST['pass'])) {
    $stmt = $db->prepare("SELECT * FROM USER WHERE id = :userId");
    $stmt->bindParam('userId', $_SESSION['userId'], SQLITE3_TEXT);
    $result = $stmt->execute();

    $olpass = $_POST['olpass'];
    if (rowCount($result) == 0) {
        $pCheck = 'Error';
    } else {
        $pass = $_POST['pass'];

        $users = array();
        $i = 0;
        while ($arr = $result->fetchArray(SQLITE3_ASSOC)) {
            $users['password'] = $arr['password'];
            $users['id'] = $arr['id'];
            $i++;
        }
        if (password_verify($olpass, $users['password'])) {
            $pCheck = 'Ok';
            $pass = password_hash($pass, PASSWORD_DEFAULT);
        } else {
            $pCheck = 'Bad_Pass';
        }
    }
}
