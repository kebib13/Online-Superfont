<?php
    include_once 'data_entry/f.php';
    $id=$row["product_id"];
    $name = $row["name"];
    $rate = $row["rate"];
    $category = get_category($conn,$row["category_id"]);
    $qty = get_qty($id);
?>
<section class="product">
    <img src="product_img/<?php echo $id; ?>.jpg">
    <article>
        <h1><?php echo $name; ?></h1>
        <h1><?php echo $category; ?></h1>
        <h1>Rs <span class='rate _<?php echo $id; ?>'><?php echo $rate; ?></span></h1>
        <div class="qty">
            <span class="sub b" onclick="alu('-', '_<?php echo $id; ?>')" >-</span>
            <span class="q" id='_<?php echo $id; ?>'><?php echo $qty; ?></span>
            <span class="add b" onclick="alu('+', '_<?php echo $id; ?>')" >+</span>
        </div>
        <div class='tag'>
        #<?php echo $id; ?>
        </div>
    </article>
</section>
