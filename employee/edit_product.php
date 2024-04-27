<?php
@include '../config.php';

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : null;
    $category = isset($_POST['category_id']) ? mysqli_real_escape_string($conn, $_POST['category_id']) : null;
    $price = isset($_POST['price']) ? mysqli_real_escape_string($conn, $_POST['price']) : null;

    // Check if the product with the given ID exists
    $checkProduct = "SELECT product_id FROM products WHERE product_id = $id";
    $result = mysqli_query($conn, $checkProduct);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the existing product data
        $row = mysqli_fetch_assoc($result);
        // Build the update query dynamically based on the provided values
        $updateFields = array();
        if ($name !== null) {
            $updateFields[] = "name = '$name'";
        }
        if ($category !== null) {
            $updateFields[] = "category_id = '$category'";
        }
        if ($price !== null) {
            $updateFields[] = "rate = '$price'";
        }

        $updateQuery = "UPDATE products SET " . implode(', ', $updateFields) . " WHERE product_id = $id";
        mysqli_query($conn, $updateQuery);

        // Handle file upload only if a file is provided
        if (!empty($_FILES['pic']['name'])) {
            
            $targetDirectory = "../product_img/";

            // Delete the existing image file
            $existingImage = $targetDirectory . $row['product_id'] . ".jpg";
            if (file_exists($existingImage)) {
                unlink($existingImage);
            }
            
            // Generate a unique filename using the product_id
            $info = pathinfo($_FILES['pic']['name']);
            $ext = $info['extension'];
            $targetFile = $targetDirectory . $id . '.' . $ext;
            
            // Move the uploaded file to the target directory
            move_uploaded_file($_FILES["pic"]["tmp_name"], $targetFile);
        }

        header('location: edit_product.php');
        exit();
    } else {
        echo "Product with ID $id not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php 
        @include 'bar.php';
        @include '../data_entry/f.php'; 
    ?>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Edit product</h3>
            <input type="number" name="id" required placeholder="enter product id">
            <input type="text" name="name" placeholder="enter product name">
            <input type="file" name="pic" accept="image/jpeg">
            <select name="category_id" required>
                <?php
                    display_category($conn);
                ?>
            </select>
            <input type="number" name="price" required placeholder="enter price">
            <input type="submit" name="submit" value="Edit Product" class="form-btn">
        </form>
    </div>
</body>

</html>
