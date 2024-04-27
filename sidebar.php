<?php
    include 'functions.php';
?>
<link rel="stylesheet" href="css/sidebar.css?1.2">
<header>
    <img class="svg-image filter" onclick="toggleSidebar()" src='images/search.svg'>
    
    <form action="" class="sidebar">
        <input type="search" id="mySearch" oninput="search(this.value)" name="query" placeholder="Search" />
        
            <h3>Choose Category:</h3>
            <select name="category_id" oninput="">
                <?php
                    echo display_category($conn);
                ?>
            </select>
        
            <h3>Sort By:</h3>
            <select name="sort" oninput="">
                <optgroup label="Price">
                    <option value="lth">Low to High</option>
                    <option value="htl">High to Low</option>
                </optgroup>
                <optgroup label="New">
                    <option value="nto">New to Old</option>
                    <option value="otn">Old to New</option>
                </optgroup>
                <optgroup label="Name">
                    <option value="asc">Ascending</option>
                    <option value="des">Descending</option>
                </optgroup>
            </select>
    </form>
    
</header>