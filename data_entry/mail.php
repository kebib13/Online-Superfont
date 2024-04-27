<?php
    if(isset($error['email'])){
        echo '<span class="error-msg">'.$error['email'].'</span>';
    }
?>
<input type="email" name="email" required placeholder="enter your email">