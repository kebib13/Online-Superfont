<?php
    include_once '../config.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    function add_product($id){
        if(!isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]=0;
        }
        $_SESSION['cart'][$id]++;
        return get_rate($id);
    }
    function sub_product($id){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]--;
            if($_SESSION['cart'][$id]==0){
                del_product($id);
            }
        }
        return get_rate($id);
    }
    function del_product($id){
        if(isset($_SESSION['cart'][$id])){
            unset($_SESSION['cart'][$id]);
            $x=0;
            $cartKeys = array_keys($_SESSION['cart']);
            foreach ($cartKeys as $id) {
                $x+=get_qty($id);
            }
            if($x==0){
                unset($_SESSION['cart']);
            }
        }
    }
    function get_rate($id){
        $conn = mysqli_connect('localhost','root','','online_storefront');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Check if the connection was successful
        if (!$conn) {
            die('Connection failed: ' . mysqli_connect_error());
        }
        error_log('get_rate function called with id: ' . $id);
        $select="SELECT rate FROM products WHERE product_id=$id";
        $result = mysqli_query($conn, $select);
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            return $row['rate'];
        }
        return 0;
    }
    function get_qty($id){
        error_log('get_qty function called with id: ' . $id);
        return isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : 0;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['f'])) {
        $f = $_GET['f'];
        $id = $_GET['id'];
    
        switch ($f) {
            case '+':
                $x = add_product($id);
                error_log('add result: ' . $x);
                echo json_encode([$x]);
                break;
            case '-':
                $x = sub_product($id);
                error_log('sub result: ' . $x);
                echo json_encode([$x]);
                break;
            case 'q':
                $x = get_qty($id);
                error_log('get_qty result: ' . $x);
                echo json_encode([$x]);
                break;
            case 'del':
                del_product($id);
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid operation']);
                break;
        }
    } else {
        // Invalid request
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }