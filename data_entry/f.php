<?php
    
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
    function get_category($conn,$id){
        $select="SELECT root_category, category_name FROM categories WHERE category_id=$id";
        $result = mysqli_query($conn, $select);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $root_id=$row['root_category'];
                $name=$row['category_name'];
                return get_category($conn,$root_id).'>>'.$name;
            }
        }
    }
    function get_indent($x){
        $s='';
        for($i=0;$i<=$x;$i++){
            $s .= '&nbsp;';
        }
        return $s;
    }
    function get_customer_info($id, $conn=null){
        if (!$conn) {
            $conn=get_conn();
        }
        $select="SELECT f_name,m_name,l_name FROM customers WHERE customer_id=$id";
        $result = mysqli_query($conn, $select);
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            if($row['m_name']){
                return $row['f_name'].' '.$row['m_name'].' '.$row['l_name'];
            }
            return $row['f_name'].' '.$row['l_name'];
        }
        return 'error';
    }
    function get_conn(){
        $conn = mysqli_connect('localhost', 'root', '', 'online_storefront');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    function display_category($conn,$id=0,$x=1){
        $select="SELECT category_id, category_name FROM categories WHERE root_category=$id";
        $result = mysqli_query($conn, $select);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $id=$row['category_id'];
                $name=$row['category_name'];
                $space=get_indent($x);
                echo '<option value='.$id.'>'.$space.$name.'</option>';
                display_category($conn,$id,$x+1);
            }
        }
    }
    function get_productname($id, $conn) {
        $select = "SELECT name FROM products WHERE product_id = $id";
        $result = mysqli_query($conn, $select);    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['name'];
        }
        return 0;
    }
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
    function get_total_count($conn, $table,$condition=null){
        $select ='SELECT COUNT(*) AS total_entries FROM '.$table. ' '.$condition;
        $result = mysqli_query($conn, $select);
        if($result->num_rows>0){
            return $result->fetch_assoc()['total_entries'];
        }
        return 0;
        
    } 
    function get_fullname($conn,$id) {
        $select = "SELECT f_name,m_name,l_name FROM customers WHERE customer_id = $id";
        $result = mysqli_query($conn, $select);    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return isset($row['m_name'])?$row['f_name'].' '.$row['m_name'].' '.$row['l_name']:$row['f_name'].' '.$row['l_name'];
        }
        return 0;
    }
    
?>