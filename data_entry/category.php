<?php
    include_once '../config.php';
    function get_indent($x){
        $s='';
        for($i=0;$i<=$x;$i++){
            $s .= '&nbsp;';
        }
        return $s;
    }

    function display_category($conn,$id=0,$x=0){
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

    echo '<select name="category_id" required>';
    display_category($conn);
    echo '</select>';
?>
