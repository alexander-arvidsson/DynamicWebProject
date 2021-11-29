<?php
session_start();
if (isset($_SESSION['userId'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Simple Post</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="site_back">
        <div id="modal" class="modal">
            <div class="m_container">
                <h4>Success! Returning you to index...</h4>
            </div>
        </div>
        <div class="container">
            <h3>Register Account</h3>
            <form class="form" id="form">
                <div class="form-control">
                    <label>Username:</label>
                    <input type="text" id="uname" name="uname">
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <label>Email:</label>
                    <input type="email" id="email" name="email">
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <label>Password:</label>
                    <input type="password" id="pass">
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <label>Confirm Password:</label>
                    <input type="password" id="pass2">
                    <small>Error Message</small>
                </div>
                <button type="button" onclick="return checkInput()">Submit</button>
                <a href="index.php">Back to site</a>
            </form>
        </div>
    </div>
    <script src="js/register.js"></script>
</body>

</html>