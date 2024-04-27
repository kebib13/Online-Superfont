<?php
    $conn = mysqli_connect('localhost','root','','online_storefront');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    function get_conn(){
        $conn = mysqli_connect('localhost','root','','online_storefront');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }