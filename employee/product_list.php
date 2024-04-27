<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product List</title>
    </head>
    <body>
        <link rel="stylesheet" href="../css/employee.css?4653">
        <?php
            @include 'bar.php';
            include_once '../functions/employee.php';
        ?>
        <!-- actual content -->
        <div class="product_list">
            <input type="search" name='name' placeholder="Product Name" maxlength="15">
            <select name="category_id" oninput="handle()" default="Category">
                <optgroup label="Category:">
                    <option value='0' >All</option>
                    <?php
                        include_once '../functions/productsAndCategories.php';
                        echo display_category($conn);
                    ?>
                </optgroup>
            </select>
            <select name="Rate" id="">
                <optgroup label="Price">
                    <option value="ra">Low to High</option>
                    <option value="rd">High to Low</option>
                </optgroup>
            </select> 
            <span id='top'></span>
            <?php
                echo product_list();
            ?>

        </div>
    </body>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="product.js?50"></script>
</html>