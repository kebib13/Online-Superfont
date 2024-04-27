<?php
@include '../config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);

    if (mysqli_num_rows($result) > 0) {
        // Update the category name
        $updateQuery = "UPDATE categories SET category_name = '$name' WHERE category_id = $categoryId";
        mysqli_query($conn, $updateQuery);

        header('location: edit_category.php');
        exit();
    } else {
        echo "Category with ID $categoryId not found.";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php  
        @include 'bar.php';
        @include '../data_entry/f.php'; 
    ?>
    <div class="form-container">
        <form action="" method="post">
            <h3>Edit Category</h3>
            <select name="category_id" required>
                <?php
                    display_category($conn);
                ?>
            </select>
            <input type="text" name="name" required placeholder="Enter category name">
            <input type="submit" name="submit" value="Rename Category" class="form-btn">
        </form>
    </div>
</body>

</html>
