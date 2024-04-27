<?php
   @include 'config.php';
   if(isset($_POST['submit'])){
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
      $select = "SELECT * FROM customers WHERE email = '$email'||phone_no = '$phone_no'";
      $result = mysqli_query($conn, $select);
      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);
         if($row['email']==$email){
            $error['email']='Email already registered!';
         }
         if($row['phone_no']==$phone_no){
            $error['phone']='Phone no already registered!';
         }
      }
      if($_POST['password'] != $_POST['cpassword']){
         $error['pwd']='Passwords do not match';

      }
      if(!isset($error)){
         $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
         $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
         $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
         $dob = mysqli_real_escape_string($conn, $_POST['dob']);
         $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
         $insert = "INSERT INTO customers (f_name, m_name, l_name, email, phone_no, pwd_hash, dob) 
               VALUES ('$f_name', '$m_name', '$l_name', '$email', '$phone_no', '$pass', '$dob')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
         exit();
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Sign Up</title>
      <link rel="stylesheet" href="../css/form.css?2351">
   </head>
   <body>
      <?php
            include 'bar.php';
      ?>
      <div class="form-container">
         <form action="" method="post">
            <h3>Sign Up</h3>
            <input type="text" name="f_name" required placeholder="enter your first name">
            <input type="text" name="m_name" placeholder="enter your middle name">
            <input type="text" name="l_name" required placeholder="enter your last name">
            <?php
               if(isset($error['email'])){
                  echo '<span class="error-msg">'.$error['email'].'</span>';
               }
            ?>
            <input type="email" name="email" required placeholder="enter your email">
            <?php
               if(isset($error['phone'])){
                  echo '<span class="error-msg">'.$error['phone'].'</span>';
               }
            ?>
            <input type="text" name="phone_no" required placeholder="enter your phone number">
            <input type="date" name="dob" required placeholder="Enter your date of birth">
            <?php
               if(isset($error['pwd'])){
                  echo '<span class="error-msg">'.$error['pwd'].'</span>';
               }
            ?>
            <input type="password" name="password" required placeholder="enter your password">
            <input type="password" name="cpassword" required placeholder="confirm your password">
            <input type="submit" name="submit" value="Sign Up" class="form-btn">
            <p>Have an account? <a href="signin.php">Sign In</a></p>
         </form>
      </div>
   </body>
</html>
