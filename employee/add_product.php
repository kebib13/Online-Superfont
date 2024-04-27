<?php
@include '../config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Handle file upload
    $targetDirectory = "../product_img/";  // Set your target directory

    // Insert product into database
    $insert = "INSERT INTO products (name, category_id, rate) 
        VALUES ('$name', '$category', '$price')";
    mysqli_query($conn, $insert);

    // Get the last inserted product ID
    $productId = mysqli_insert_id($conn);

    // Generate a unique filename using the product_id
    $info = pathinfo($_FILES['pic']['name']);
    $ext = $info['extension'];
    $targetFile = $targetDirectory . $productId.'.'.$ext;
    move_uploaded_file($_FILES["pic"]["tmp_name"], $targetFile);

    header('location:add_product.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php 
        @include 'bar.php';
        @include '../data_entry/f.php'; 
    ?>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>add product</h3>
            <input type="text" name="name" required placeholder="enter product name">
            <input type="file" name="pic" required accept="image/jpeg">
            <select name="category_id" required>
                <?php
                    display_category($conn);
                ?>
            </select>
            <input type="number" name="price" required placeholder="enter price">
            <input type="submit" name="submit" value="Add Product" class="form-btn">
        </form>
    </div>
</body>

</html>
