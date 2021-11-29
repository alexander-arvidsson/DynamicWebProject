<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet" href="css/modal.css">
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
            <?php
            if (isset($_SESSION['userId'])) {
                echo '<button id="m1" class="dropbtn" onclick="return showMenu()">Menu</button>
                <div id="dropdown" class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>';
            } else {
                echo '<button id="m1" class="dropbtn" onclick="showMenu()">Login</button>';
            }
            ?>
        </div>
    </div>
    <div class="site_back">
    <div class="searchModal" id="searchModal">
        <div id="modalArea" class="modalArea"></div>
    </div>
        <?php
        if (isset($_SESSION['userId'])) {
            echo '<div id="post_comment" class="write_p">
            <div class="c_container">
                <form id="form">
                <div class="container-control">
                    <label for="topic"><b>Topic:</b></label> 
                    <input type="text" placeholder="Enter a topic" name="topic" id="topic" required>
                    <small>Error Message</small>
                </div>
                <div class="container-control">
                    <label for="container"><b>Comment:</b></label>
                    <textarea name="comment" id="comment"></textarea>
                    <small>Error Message</small>
                 </div>
                 <div class="container-control">
                    <button type="button" id="sub" onclick="return postComment()">Post Comment</button>
                </div>
                </form>
            </div>
        </div>
        <script src="js/postComment.js"></script>';
        } ?>
        <br>
        <div class="content" id="content">
        </div>
        <div class="footer">
            <button id="load" class="pagebtn" title="Load more">
            <i class="fa fa-chevron-down"></i>
            </button>
            <script src="js/search.js"></script>
            <script src="js/index.js"></script>
        </div>

        <?php
        if (!isset($_SESSION['userId'])) {
            echo '<div id="login" class="modal">
                    <div class="l_container">
                        <form id="form">
                        <div class="container-control">
                            <label for="uname"><b>Username</b></label>
                            <input type="text" placeholder="Enter Username or Email" name="uname" id="uname" required>
                            <small>Error Message</small>
                        </div>
                        <div class="container-control">
                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                            <small>Error Message</small>
                         </div>
                         <div class="container-control">
                            <button type="button" id="sub" onclick="return login()">Login</button>
                        </div>
                            <button type="button" onclick="return cancelLogin()" class="cancelbtn">Cancel</button>
                            <button type="button" class="registrbtn" onclick="return registr()">Register</button>
                        </form>
                    </div>
                </div>
                <script src="js/login.js"></script>';
        }
        ?>
    </div>
</body>

</html>