<!DOCTYPE html>
<html>
    <head>

    </head>
<?php
$username = $_POST['username'] ?? 'guest';
$password = $_POST['password'] ?? '';
?>
    <body>
        <form action = "" method="POST">
            <input type='text' name='username' value="<?php echo $username;?>">
            <input type='password' name='password' value="">
            <input type='submit' name='submit'>
        </form>

    <?php
    if (isset($_POST['submit'])){
        if ($username == 'bforeman' && $password == 'GOAT')
        echo "Welcome, $username";
    else
        echo "Invalid login.";
    }

    ?>
    </body>
</html>