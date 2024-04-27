<?php
   if(isset($error['pwd'])){
      echo '<span class="error-msg">'.$error['pwd'].'</span>';
   }
?>
<input type="password" name="password" required placeholder="enter your password">
<input type="password" name="cpassword" required placeholder="confirm your password">