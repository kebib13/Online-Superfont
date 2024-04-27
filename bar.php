<link rel="stylesheet" href="css/bar.css?">
<header>
    <img src="images/menu.svg" alt="" class="menu svg-image" onclick="togglemenu()">
    <div class="barcontent">
        <a href="index.php" class="logo"><img src="images/logo.svg"></a>
        
        <?php
            session_start();
            if(isset($_SESSION['name'])){
                echo '
                    <div class="dropdown">
                        <div class="dropbtn">Hi '.$_SESSION['name'].' ▼</div>
                        <div class="dropdown-content">
                            <a href="profile.php" class="btn">My Profile</a>
                            <a href="history.php" class="btn">History</a>
                            <a href="logout.php" class="btn">Logout</a>
                        </div>
                    </div>
                ';
            }
            else{
                echo '
                    <div><a href="login.php">Log In</a> / <a href="register.php">Sign up</a></div>
                ';
            }
        ?>
    </div>
</header>
<img src="images/cart.svg" alt="" class="cart svg-image" onclick="togglemenu()">