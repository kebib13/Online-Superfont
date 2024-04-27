<?php
require_once "mail/mailer.php";
session_start();

$otp=mt_rand(10000,999999);
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

         $mailTemplate="

        <p>Verify your email address through OTP</p>
        <p>Your OTP is "  .$otp.  ".Enter the provided otp</p>"; 

        $subject="Email Verification from Online StoreFont";

         if(emailVerification($email,$mailTemplate,$subject)){

            $_SESSION['otp']=$otp;
            $_SESSION['f_name']=$f_name;
            $_SESSION['m_name']=$m_name;
            $_SESSION['l_name']=$l_name;
            $_SESSION['dob']=$dob;
            $_SESSION['pass']=$pass;

            header("Location: otpForm.php");

         }
         else{
            die ("email not send ");
         }
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
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php
         @include 'bar.php';
      ?>
      <div class="form-container">
         <form action="" method="post">
            <h3>register now</h3>
            <?php
               @require 'data_entry/name.php';
               @require 'data_entry/mail.php';
               @require 'data_entry/phone.php';
               echo '<input type="date" name="dob" required placeholder="Enter your date of birth">';
               @require 'data_entry/cpass.php';
            ?>
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Log In</a></p>
         </form>
      </div>
   </body>
</html>