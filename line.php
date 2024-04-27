    <?php
        $name = $row["name"];
        $rate = $row["rate"];
        $qty = get_qty($id);
        $sub = $rate * $qty;
        $gross+=$sub;
    ?>

    <h5 class="_<?php echo $id; ?>"><?php echo $name; ?></h5>
    <h5 class="_<?php echo $id; ?>">Rs <span class="rate _<?php echo $id; ?>"><?php echo $rate; ?></span></h5>
    <div class="qty _<?php echo $id; ?>">
    
        <span class="sub b" onclick="alu('-', '_<?php echo $id; ?>')">-</span>
        <span class="q" id="_<?php echo $id; ?>"><?php echo $qty; ?></span>
        <span class="add b" onclick="alu('+', '_<?php echo $id; ?>')">+</span>
    </div>
    <h5 class="_<?php echo $id; ?>">Rs <span class="subTotal _<?php echo $id; ?>"><?php echo $sub; ?></span></h5>
    <img src="delete.png" alt="Delete" class="d _<?php echo $id; ?>" onclick="del('_<?php echo $id; ?>')">

