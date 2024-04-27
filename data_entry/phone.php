<?php
    if(isset($error['phone'])){
        echo '<span class="error-msg">'.$error['phone'].'</span>';
    }
?>
<input type="text" name="phone_no" required placeholder="enter your phone number">