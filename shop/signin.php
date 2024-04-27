<?php
    include '../config.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $select = "SELECT * FROM customers WHERE email = '$email'";
        $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            if(password_verify($_POST['password'], $row['pwd_hash'])){
                $_SESSION['name'] = $row['f_name'];
                $_SESSION['fullname'] = isset($row['m_name'])?$row['f_name'].' '.$row['m_name'].' '.$row['l_name']:$row['f_name'].' '.$row['l_name'];
                $_SESSION['user_id'] = $row['customer_id'];
                $_SESSION['access']='customer';
                header('location:index.php');
            }
            else{
                $error['pwd']='incorrect password!';
            }         
        }else{
            $error['email'] = 'email not registered';
        }
    };
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In</title>
        <link rel="stylesheet" href="../css/form.css?89451298465">
    </head>
    <body>
        <?php
            include 'bar.php'; 
        ?>
        <div class="form-container">
            <form action="" method="post">
                <h3>Sign In</h3>
                <?php
                    if(isset($error['email'])){
                        echo '<span class="error-msg">'.$error['email'].'</span>';
                    }
                ?>
                <input type="email" name="email" required placeholder="enter your email">
                <?php
                    if(isset($error['pwd'])){
                        echo '<span class="error-msg">'.$error['pwd'].'</span>';
                    }
                ?>
                <input type="password" name="password" required placeholder="enter your password">
                <input type="submit" name="submit" value="Sign In" class="form-btn">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </body>
</html>
