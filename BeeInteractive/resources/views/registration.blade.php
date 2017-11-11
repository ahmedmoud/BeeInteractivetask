<?php

?>

<!doctype html>
<html>
    <title>
        BeeInteractive
    </title>
    
    <header>
   Registration :
        </header>
            <form method="POST" action="home"><br><br>
                {!! csrf_field() !!}
                <input type="text" name="name" placeholder="name" required=""><br><br>
                <input type="email" name="email" placeholder="E-mail" required=""><br><br>
                <input type="password" name="password" placeholder="Password" required=""><br><br>
                <input type="password" name="cpassword" placeholder="confirm Password" required=""><br><br>
                Role  : <select name="role" required="">
                  <?php if(isset($users)){for($i=0; $i<count($users); $i++){ ?>
                   <option value="<?php echo $users[$i]->id;?>"><?php echo $users[$i]->role;?></option>
`              
                  <?php } }?>
                </select><br><br>

                <input type="submit" value="Register" >
            </form>
    <?php
    if(isset($result)){
     echo $result;
    }
        ?>
</html>

