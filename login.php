<?php
    session_start();
    require 'functions.php';

    if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        
        $id = $_COOKIE['id'];
        $username = $_COOKIE['key'];

        $res = mysqli_query($db, "SELECT username FROM user_practice WHERE id = $id");
        $row = mysqli_fetch_assoc($res);

        if($username === hash('sha256', $row['username']) ){
            $_SESSION['login'] = true;
        }
    }
    

    if (isset($_SESSION["login"])) {
        header("Location: table.php");
        exit;
    }
    

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
                $_SESSION["login"] = true;

                //cookie
                if(isset($_POST['remember'])){
                    setcookie('id',$row['id'], time() + 120);
                    setcookie('key', hash('sha256', $row['username']), time() + 120);
                }

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
    <style>
        ul {
            list-style-type: none;
        }

        button{
            cursor: pointer;
        }
    </style>
    <title>Login</title>
</head>
<body>
<div class="container">
            
            <form action="" method="post">

            <ul>
                <li>
                    <h1>Login</h1>
                </li>
                
                <?php if(isset($error)): ?>
                    <p style="color:red">Invalid username/password</p>
                <?php endif; ?>

                <li>
                    <label for="username">Username</label><br>
                    <input type="text" name="username" id="username" required>
                </li>
                <li>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password" required>
                </li>
                    <br>
                <li>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label><br>
                </li>
                <br>
                <li> 
                    <button type="submit" name="submit">Sign In</button>
                    <a href="registrasi.php">Sign Up</a>
                </li>

            </ul>
                
                
                
            </form>
</div>    
</body>
</html>