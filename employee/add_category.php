<?php
@include '../config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category_id']);

    // Insert category into database
    $insert = "INSERT INTO categories (category_name, root_category) 
        VALUES ('$name', '$category')";
    mysqli_query($conn, $insert);

    header('location:add_category.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php  
        @include 'bar.php';
        @include '../data_entry/f.php'; 
    ?>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>add category</h3>
            <select name="category_id" required>
                <option value="0">Root</option>
                <?php
                    display_category($conn);
                ?>
            </select>
            <input type="text" name="name" required placeholder="enter category name">
            <input type="submit" name="submit" value="Add Category" class="form-btn">
        </form>
    </div>
</body>

</html>
