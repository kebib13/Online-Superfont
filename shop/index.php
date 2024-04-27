<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        
      
    </head>
    <body>
        <?php
            include 'bar.php';
            include 'searchbar.php';
        ?>
        <link rel="stylesheet" href="../css/product.css?231">
        <div class="product_display">
            <?php
                $sql='SELECT * FROM products ';
                $condition='';
                // Check if the form has been submitted
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Check if the 'query' parameter is set
                    if (isset($_GET['query'])) {
                        // Retrieve and sanitize the value of the 'query' parameter
                        $search_query = trim(htmlspecialchars($_GET['query']));
                        // Use $search_query for further processing, such as querying a database or performing a search
                        if($search_query!=NULL){
                            $condition.="WHERE name LIKE '$search_query' ";
                        }
                    }
                
                    // Check if the 'category_id' parameter is set
                    if (isset($_GET['category_id'])) {
                        // Retrieve and sanitize the value of the 'category_id' parameter
                        $category_id = htmlspecialchars($_GET['category_id']);
                        // Use $category_id for further processing, such as querying a database based on category
                        if($category_id!=NULL){
                            $x=implode(',', get_subcategory_list($category_id));
                            $category_list="category_id IN (".$x.')';
                            if($condition!=NULL){
                                $condition.='AND '.$category_list;
                            }
                            else{
                                $condition.='WHERE '.$category_list;
                            }
                        }
                    }
                
                    // Check if the 'sort' parameter is set
                    if (isset($_GET['sort'])) {
                        // Retrieve and sanitize the value of the 'sort' parameter
                        $sort_option = htmlspecialchars($_GET['sort']);
                        $sort=' ORDER BY ';
                        // Use $sort_option for further processing, such as sorting query results
                        switch(substr($sort_option,0,1)){
                            case 'r':
                                $sort.='rate ';
                                break;
                            case 'n':
                                $sort.='name ';
                                break;
                            case 'i':
                                $sort.='product_id ';
                                break;
                        }
                        switch(substr($sort_option,1,2)){
                            case 'a':
                                $sort.='ASC';
                                break;
                            case 'd':
                                $sort.='DESC';
                                break;
                            
                        }
                        $condition.=$sort;
                    }
                }

                $page=isset($_GET['page'])?$_GET['page']:1;
                echo get_products($page,$sql.$condition);
            ?>
        </div>
    </body>
</html>