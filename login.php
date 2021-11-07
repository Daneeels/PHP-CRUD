<?php
    require 'functions.php';

    if (isset($_POST["submit"])) {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query_user = mysqli_query($db, "SELECT * FROM user_practice 
                                    WHERE username = '$username'");
        
        //Cek username
        if (mysqli_num_rows($query_user) == 1) {
            
            //Cek password
            $row = mysqli_fetch_assoc($query_user);
            if (password_verify($password, $row['password'])) {
                header("Location: table.php");
                exit;
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="post">

    <ul>
        <?php if(isset($error)): ?>
            <p style="color:red">Invalid username/password</p>
        <?php endif; ?>
        <li>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </li>
            <li> <button type="submit" name="submit">Sign In</button>
        </li>
    </ul>
        
        
        
    </form>
</body>
</html>