<?php
?>

<!doctype html>
<html>
    <title>
        BeeInteractive
    </title>
    
    <header>
        Login in :
        </header>
            <form method="POST" action="profile"><br><br>
                
                {!! csrf_field() !!}
                <input type="email" name="email" placeholder="E-mail"><br><br>
                <input type="password" name="password" placeholder="Password"><br><br>
                <input type="submit" value="Login" >
            </form>
    <br><br>
    <a href="registration">Register</a><br><br>
    <a href="login/facebook">Login with facebook</a>

    <?php if(isset($result)){echo $result;}?>
    
</html>