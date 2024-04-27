    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order history</title>
        </head>
        <body>
            <script src="j.js"></script>
            <div class="product_display">
                <?php
                    @include 'data_entry/f.php';
                    @include 'bar.php';
                    @include 'config.php';
                    // Define how many items to show per page
                    $itemsPerPage = 30;

                    // Get the current page number from the query string, or default to page 1
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                    // Calculate the offset based on the current page number and the number of items per page
                    $offset = ($page - 1) * $itemsPerPage;

                    $condition='WHERE customer_id='.$_SESSION['user_id'];
                    $query = "SELECT order_id,order_date,delivery_charge,shipping_address FROM orders ".$condition." ORDER BY order_date DESC";
                    $result = $conn->query($query);
                    // Check if there are any orders
                    if ($result->num_rows > 0) {
                        // Loop through each row in the result set
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <div class="bill">
                                    <div class="bill_data">
                                        <h4>Name:</h4>
                                        <h4>Shipping Address:</h4>
                                        <h4>Delivery Charge:</h4>
                                        <h4>Order ID:</h4>
                                        <h4>Order Date:</h4>
                                        <h5>' . $_SESSION['fullname'] . '</h5>
                                        <h5>' . $row['shipping_address'] . '</h5>
                                        <h5>' . (isset($row['delivery_charge']) ? $row['delivery_charge'] : 0) . '</h5>
                                        <h5>' . $row['order_id'] . '</h5>
                                        <h5>' . $row['order_date'] . '</h5>
                                    </div>
                                    <div class="item_list">
                                        <h4>Name</h4>
                                        <h4>Rate</h4>
                                        <h4>Qty</h4>
                                        <h4>Amount</h4>
                            ';
                            $query2 = "SELECT  product_id, quantity, rate FROM orderproducts WHERE order_id=$row[order_id]";
                            $result2 = $conn->query($query2);
                            $gross=0;
                            while ($row2 = $result2->fetch_assoc()) {
                                $rate = $row2["rate"];
                                $qty = $row2["quantity"];
                                $sub = $rate * $qty;
                                $gross += $sub;
                                echo '
                                        <h5>' . get_productname($row2["product_id"], $conn) . '</h5>
                                        <h5>' . $rate . '</h5>
                                        <h5>' . $qty . '</h5>
                                        <h5>' . $sub . '</h5>
                                ';
                            }
                            echo '  
                                    </div>
                                    <h4>Gross Total: ' . $gross . '</h4>
                                </div>    
                            ';
                        }
                    }
                ?>
            </div>
            <?php
                // Pagination links
                $totalItems = get_total_count($conn,'orders',$condition); // Implement a function to get the total number of products
                $totalPages = ceil($totalItems / $itemsPerPage);

                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            ?>
        </body>

    </html>
