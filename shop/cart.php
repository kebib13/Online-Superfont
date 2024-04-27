<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    
</head>

<body>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="script.js"></script>
    
        <?php
        @include_once '../ajax/cart.php';
        @include 'bar.php';
        function display_location($conn){
            $select="SELECT address FROM shipping";
            $result = mysqli_query($conn, $select);
            if($result->num_rows>0){
                $x='';
                while($row=$result->fetch_assoc()){
                    $id=$row['address'];
                    $x.= '<option value='.$id.'>'.$id.'</option>';
                }
                return $x;
            }
        }
        
        if (isset($_POST['submit']) && isset($_SESSION['cart'])) {
            $cartKeys = array_keys($_SESSION['cart']);
            if(isset($_SESSION['user_id'])){
                $shipping = mysqli_real_escape_string($conn, $_POST['shipping']) . ' ' . mysqli_real_escape_string($conn, $_POST['specific']);
                $insert = "INSERT INTO orders (customer_id, shipping_address) 
                VALUES ('$_SESSION[user_id]', '$shipping')";
                $result=mysqli_query($conn, $insert);
        
                // Get the last inserted order ID
                $orderId = mysqli_insert_id($conn);
                foreach ($cartKeys as $id) {
                    $qty=get_qty($id);
                    if($qty>0){
                        $query = "SELECT rate FROM products WHERE product_id=$id";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        $rate = $row["rate"];
                        $insert = "INSERT INTO orderproducts (order_id, product_id, quantity, rate) 
                        VALUES ('$orderId', '$id', '$qty','$rate')";
                        $result=mysqli_query($conn, $insert);
                    }
                }
                unset($_SESSION['cart']);
                header('location:index.php');
                exit();
        
            }
            header('location:signin.php');
            exit();
        }
        ?>
        <link rel="stylesheet" href="../css/cart.css?3898">
        <div class="bill">
            <h1>Bill</h1>
            <div class="bill_t">
                <h4>Name</h4>
                <h4>Rate</h4>
                <h4>Qty</h4>
                <h4>Amount</h4>
                <span></span>
        <?php
        if(isset($_SESSION['cart'])) {
            // Get all keys in the $_SESSION['cart'] array
            $cartKeys = array_keys($_SESSION['cart']);
            $gross = 0;
            foreach ($cartKeys as $id) {
                $query = "SELECT name, rate FROM products WHERE product_id=$id";
                $result = $conn->query($query);

                if ($result) {
                    $row = $result->fetch_assoc();
                    $name = $row["name"];
                    $rate = $row["rate"];
                    $qty = get_qty($id);
                    $sub = $rate * $qty;
                    $gross+=$sub;
                    echo '<h5 class="_' . $id . '">' . $name . '</h5>' .
    '<h5 class="_' . $id . '">Rs <span class="rate _' . $id . '">' . $rate . '</span></h5>' .
    '<div class="qty _' . $id . '">' .
        '<span class="sub b" onclick="alu(\'-\', \'_' . $id . '\')">-</span>' .
        '<span class="q" id="_' . $id . '">' . $qty . '</span>' .
        '<span class="add b" onclick="alu(\'+\', \'_' . $id . '\')">+</span>' .
    '</div>' .
    '<h5 class="_' . $id . '">Rs <span class="subTotal _' . $id . '">' . $sub . '</span></h5>' .
    '<img src="../images/icons/delete.png" alt="Delete" class="d _' . $id . '" onclick="del(\'_' . $id . '\')">';
                }
            }
            echo '
                </div>
                <div class="total">
                    <h5>Total: </h5><span id="g_total">' . $gross . '</span>
                </div>
                <form action="" method="post">
                    <h3>Shipping Address</h3>
                    <select name="shipping" required>'.
                        display_location($conn)
                    . '</select>
                    <input type="text" name="specific" required placeholder="Enter specific landmarks">
                    <input type="submit" name="submit" value="Confirm Order" class="form-btn">
                </form>
                
            ';
        } else {
            echo "No items in cart
            </div>";
        }
        ?>
    </div>
</body>

</html>
