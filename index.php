<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Index</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php
            @include 'bar.php';
            @include 'config.php';
            
        ?>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="j.js"></script>
        
                <?php
                    echo '<div class="product_display">';
                    
                    // Define how many items to show per page
                    $itemsPerPage = 30;

                    // Get the current page number from the query string, or default to page 1
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                    // Calculate the offset based on the current page number and the number of items per page
                    $offset = ($page - 1) * $itemsPerPage;

                    $condition='';

                    // Retrieve a limited number of rows based on the offset and the number of items per page
                    $sql = "SELECT * FROM products ".$condition." ORDER BY product_id DESC LIMIT $itemsPerPage OFFSET $offset";

                    // Execute the query and get the result
                    $result = $conn->query($sql);

                    include_once 'data_entry/f.php';

                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Loop through each row in the result set
                        while ($row = $result->fetch_assoc()) {
                            // Access and display the data from the current row
                                {include 'product.php';}
                            
                        }
                        echo '</div>';
                        // Pagination links
                        $totalItems = get_total_count($conn,'products'); // Implement a function to get the total number of products
                        $totalPages = ceil($totalItems / $itemsPerPage);

                        echo '<div class="pagination">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo '<a href="?page=' . $i . '">' . $i . '</a>';
                        }
                        echo '</div>';
                        


                    } else {
                    echo "0 results";
                    echo '</div>';
                    }

                ?>
        </div>
        
    </body>
</html>