<?php
    function get_conn(){
        $conn = mysqli_connect('localhost', 'root', '', 'online_storefront');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    $conn=get_conn();
    function get_indent($x){
        $s='';
        for($i=1;$i<=$x;$i++){
            $s.= '&nbsp;&nbsp;';
        }
        return $s;
    }
    //returns categories as options for select
    function display_category($conn=NULL, $id = 0, $x = 1) {
        if (!$conn) {
            $conn=get_conn();
        }
        // Initialize an empty string to store the generated HTML
        $html = "";
    
        // Select categories with the given root_category
        $sql = "SELECT category_id, category_name FROM categories WHERE root_category = $id";
        $result = mysqli_query($conn, $sql);
        
    
        // Check if there are any categories
        if ($result->num_rows > 0) {
            // Loop through each row in the result set
            while ($row = $result->fetch_assoc()) {
                // Get category_id and category_name from the row
                $id = $row['category_id'];
                $name = $row['category_name'];
    
                // Generate indentation based on the level
                $space = get_indent($x);
    
                // Append the <option> element with the category information to the HTML
                $html .= '<option value=' . $id . '>' . $space . $name . '</option>';
    
                // Recursively call the function for subcategories and append the result
                $html .= display_category($conn, $id, $x + 1);
            }
        }
        // Return the accumulated HTML
        return $html;
    }
    function get_subcategory_list($id, $conn=NULL) {
        if (!$conn) {
            $conn=get_conn();
        }
        $categoryList = [$id]; // Start with the current category ID
        $sql = "SELECT category_id FROM categories WHERE root_category = $id";
        $result = mysqli_query($conn, $sql);
        
        while ($row = $result->fetch_assoc()) {
            // Recursively call the function to get subcategories
            $subCategoryList = get_subcategory_list($row['category_id'], $conn);
            // Merge the subcategory list with the current category list
            $categoryList = array_merge($categoryList, $subCategoryList);
        }
        
        return $categoryList;
    }
    function get_products($page,$condition,$conn=null){
        if (!$conn) {
            $conn=get_conn();
        }
        $itemsPerPage = 30;
        $offset = ($page - 1) * $itemsPerPage;
        // Retrieve a limited number of rows based on the offset and the number of items per page
        $sql = $condition." LIMIT $itemsPerPage OFFSET $offset";
        // Execute the query and get the result
        $result = $conn->query($sql);
        $x=' ';
        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Loop through each row in the result set
            while ($row = $result->fetch_assoc()) {
                // Access and display the data from the current row
                    $x.=get_product_html($conn,$row);
                
            }
        }
        else{
            $x='No Products Found';
        }
        return $x;
    }
    function get_product_html($conn,$row){
        $id=$row["product_id"];
        $name = $row["name"];
        $rate = $row["rate"];
        $category = get_category($conn,$row["category_id"]);
        $qty = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : 0;
        return "
        <div class='product'>
            <div class='product_img' style='background-image: url(../images/products/$id.jpg)'>
                <div class='tag'>
                    #$id
                </div>
                <div class='qty _$id'>
                    <span class='sub b' onclick=\"alu('-', '_$id')\">-</span>
                    <span class='q' id='_$id'>$qty</span>
                    <span class='add b' onclick=\"alu('+', '_$id')\">+</span>
                </div>
            </div>
            <article>
                <h1>$name</h1>
                <h3>$category</h3>
                <h4>Rs <span class='rate _$id'>$rate</span></h4>
            </article>
        </div>";
    }
    function get_category($conn, $id) {
        $select = "SELECT root_category, category_name FROM categories WHERE category_id = $id";
        $result = mysqli_query($conn, $select);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['root_category']==0){
                return $row['category_name'];
            }
            return get_category($conn,$row['root_category']).' >> '.$row['category_name'];
        }
    }