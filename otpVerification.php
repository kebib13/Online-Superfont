<?php

    if(isset($_POST['Verify']) && $_SERVER['REQUEST_METHOD']=="POST")
    {
        
        @include 'config.php';
        session_start();

        $otp=intval($_SESSION['otp']);
        $enteredOtp=intval($_POST['enteredOtp']);
        $f_name=$_SESSION['f_name'];
        $f_name=$_SESSION['m_name'];
        $f_name=$_SESSION['l_name'];
        $dob=$_SESSION['dob'];
        $pass=$_SESSION['pass'];


        if($otp===$enteredOtp)
        {
            $insert = "INSERT INTO customers (f_name, m_name, l_name, email, phone_no, pwd_hash, dob) 
                  VALUES ('$f_name', '$m_name', '$l_name', '$email', '$phone_no', '$pass', '$dob')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
            exit();
        }

        else
        {  
            echo
        '<script>
        alert("Invalid OTP");
        
        </script>';
            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
    <link rel="stylesheet" href="./css/otpform.css">
</head>
<body>
<div class="overlay">
            <div class="popup">
                <h5>Check Your mail and enter the OTP below:</h5>
    <form method="POST" id="otpForm">
                <div>
                    <input type="text" name="enteredOtp" maxlength="6" required>
                </div>
                <button type="submit" name="Verify" id="hideButton">Submit</button>
    </form>
</div>
</div>

</body>
</html>