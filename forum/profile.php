<?php
session_start();
if (!isset($_SESSION['userId'])) {
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="header">
        <a href="index.php" id="home" class="homebtn">Home</a>
        <div class="search">
            <input type="text" id="search" placeholder="Search comments...">
            <button id="confirmSearch" class="searchbtn" onclick="return startSearch()"><i class="fa fa-search"></i></button>
            <select id="opt">
                <option >All</option>
                <option>Topic</option>
                <option>Content</option>
            </select>      
        </div>
        <div id="menu" class="menu">
            <button id="m1" class="dropbtn" onclick=" return showMenu()">Menu
            <i class="fa fa-sort-down"></i></button>
            <div id="dropdown" class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="site_back">
    <div class="searchModal" id="searchModal">
        <div id="modalArea" class="modalArea"></div>
    </div>
        <h3>Profile:</h3>
        <div class="info" id="info"></div>
        <div class="profile">
            <form class="form" id="form">
                <div class="picture-control">
                    <label>Upload or change profile picture:</label>
                    <input type="file" id="pic" name="pic">
                    <small>Error Message</small>
                    <button type="button" class="submit" onclick="return checkUpload()">Upload Image</button>
                </div>
                <div class="container-control">
                    <label>New Username:</label>
                    <input type="text" id="uname" name="uname">
                    <small>Error Message</small>
                </div>
                <div class="container-control">
                    <label>New Email:</label>
                    <input type="email" id="email" name="email">
                    <small>Error Message</small>
                </div>
                <div class="container-control">
                    <label>Old Password:</label>
                    <input type="password" id="olpass" name="olpass">
                    <small>Error Message</small>
                </div>
                <div class="container-control">
                    <label>New Password:</label>
                    <input type="password" id="pass" name="pass">
                    <small>Error Message</small>
                </div>
                <div class="container-control">
                    <button type="button" class="submit" onclick="return checkInput()">Submit changes</button>
                    <small class="complete" id="complete">Success!</small>
                </div>

        </div>
    </div>
    <script src="js/search.js"></script>
    <script src="js/profile.js"></script>
</body>

</html>