<?php
@include '../config.php';
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $select = "SELECT * FROM employees WHERE email = '$email'||phone_no = '$phone_no'";
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
    if (!isset($error)) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $insert = "INSERT INTO employees (fullname, email, phone_no, pwd_hash, dob) 
            VALUES ('$name', '$email', '$phone_no', '$pass', '$dob')";
        mysqli_query($conn, $insert);
        header('location:add_employee.php');
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
    <title>Employee Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php @include 'bar.php'; ?>
    <div class="form-container">
        <form action="" method="post">
            <h3>add employee</h3>
            <?php
                echo '<input type="text" name="name" required placeholder="enter your full name">';
                require '../data_entry/mail.php';
                require '../data_entry/phone.php';
                echo'<input type="date" name="dob" required placeholder="Enter your date of birth">';
                require '../data_entry/cpass.php';
                
            ?>
            <input type="submit" name="submit" value="Register Employee" class="form-btn">
        </form>
    </div>
</body>

</html>
