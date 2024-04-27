<?php
    function product_list($category = '', $page = 1) {
        // Set offset and limit
        $itemsPerPage = 30;
        $offset = ($page - 1) * $itemsPerPage;
        $limitClause = "LIMIT $itemsPerPage";
        $offset = ($offset != 0) ? "OFFSET $offset" : '';
    
        // Initialize database connection
        $conn = get_conn();
        $details = '';
    
        // Construct the SQL query with optional category filter
        $sql = "SELECT p.*, c.category_name 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.category_id";
        if (!empty($category)) {
            $categoryList = implode(',', get_category_list($conn, $category));
            $sql .= " WHERE p.category_id IN ($categoryList)";
        }
        $sql .= " ORDER BY p.product_id DESC $limitClause $offset";
    
        // Execute the query
        $result = mysqli_query($conn, $sql);
    
        // Process the query result
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['product_id'];
                $name = $row['name'];
                $category_name = $row['category_name']; // Use category name instead of category ID
                $rate = $row['rate'];
    
                // Append product details to $details
                $details .= "<h5 class='name'>$name</h5>";
                $details .= "<h5 class='category'>$category_name</h5>"; // Use category name instead of category ID
                $details .= "<h5 class='rate'>$rate</h5>";
                $details .= "<a href='product.php?id=$product_id' class='edit'></a>";
            }
        }
    
        // Close database connection
        mysqli_close($conn);
    
        return $details;
    }
    
    
    function get_category_list($conn, $id) {
        $categoryList = [$id]; // Start with the current category ID
        $sql = "SELECT category_id FROM categories WHERE root_category = $id";
        $result = mysqli_query($conn, $sql);
        
        while ($row = $result->fetch_assoc()) {
            // Recursively call the function to get subcategories
            $subCategoryList = get_category_list($conn, $row['category_id']);
            // Merge the subcategory list with the current category list
            $categoryList = array_merge($categoryList, $subCategoryList);
        }
        
        return $categoryList;
    }
?>