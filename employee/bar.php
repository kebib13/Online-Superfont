<link rel="stylesheet" href="../css/bar.css">
<header>
    
        <a href="index.php" class="home-btn">Home</a>
        <div class="dropdown">
            <button class="dropbtn">Product ▼</button>
            <div class="dropdown-content">
                <a href="add_product.php" class="home-btn">Add</a>
                <a href="edit_product.php" class="btn">Edit</a>
                <a href="delete_product.php" class="btn">Delete</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Categories ▼</button>
            <div class="dropdown-content">
                <a href="add_category.php" class="home-btn">Add</a>
                <a href="edit_category.php" class="btn">Edit</a>
                <a href="delete_category.php" class="btn">Delete</a>
            </div>
        </div>
        <a href="add_employee.php" class="home-btn">Add Employee</a>
        
        
    <?php
        //if(!isset($_SESSION['user_id']) || $_SESSION['access']!='employee'){
          //  header('location:../index.php');
        //}
    ?>
</header>
<link rel="stylesheet" href="../css/style.css">