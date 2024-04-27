<link rel="stylesheet" href="../css/sidebar.css?3898">
<header>
    <img class="svg-image filter" onclick="toggleSidebar()" src='../images/icons/search.svg'/>
    
    <form action="" class="sidebar" method='get'>
        <h3>Name:</h3>
        <input type="search" id="mySearch" name="query" placeholder="Search" maxlength="10"/>
        
        <h3>Category:</h3>
        <select name="category_id" oninput="">
            <option value='0' >All</option>
            <?php
                include_once '../functions/productsAndCategories.php';
                echo display_category($conn);
            ?>
        </select>
        
        <h3>Sort By:</h3>
        <select name="sort" oninput="">
            <optgroup label="Price">
                <option value="ra">Low to High</option>
                <option value="rd">High to Low</option>
            </optgroup>
                <optgroup label="New">
                <option value="ia">New to Old</option>
                <option value="id">Old to New</option>
            </optgroup>
            <optgroup label="Name">
                <option value="na">Ascending</option>
                <option value="nd">Descending</option>
            </optgroup>
        </select>
        <h3></h3>
        <input type="submit" value='Search'>
    </form>
    <a href="cart.php"><img src="../images/icons/cart.svg" alt="" class="cart svg-image"></a>
</header>

