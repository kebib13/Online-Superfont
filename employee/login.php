<?php
   @include '../config.php';
   session_start();
   if(isset($_POST['submit'])){
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $select = "SELECT * FROM employees WHERE email = '$email'";
      $result = mysqli_query($conn, $select);
      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);
         if(password_verify($_POST['password'], $row['pwd_hash'])){
            session_unset();
            session_destroy();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['access']='employee';
            header('location:index.php');
         }
         header('location:../login_form.php');         
      }
      header('location:../login_form.php');
   };
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
      <link rel="stylesheet" href="../css/style.css">
   </head>
   <body>
      <div class="form-container">
         <form action="" method="post">
            <h3>login now</h3>
            <?php
               require '../data_entry/mail.php';
               require '../data_entry/pass.php';
            ?>
            <input type="submit" name="submit" value="login" class="form-btn">
         </form>
      </div>
   </body>
</html>
