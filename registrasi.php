<?php
    require 'functions.php';

    if(isset($_POST['signup'])){
        
         if(signup($_POST) > 0){
            echo "<script>
                    alert('Signup SUCCESS');
                </script>
            ";
         }else {
             echo mysqli_error($db);
         }
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
    <title>Sign Up</title>
</head>
<body>

    <div class="container">

        
        <form action="" method="post">
            <ul>
                <li>
                    <h1>Sign Up</h1>
                </li>

                <li>
                    <label for="username">Username</label> <br>
                    <input type="text" name="username" id="username" required>
                </li>
                <li>
                    <label for="pass">Password</label><br>
                    <input type="password" name="pass" id="pass" required>
                </li>
                <li>
                <label for="pass2">Confirm Password</label><br>
                    <input type="password" name="pass2" id="pass2" required>
                </li>
                <br>
                <li>
                    <button type="submit" name="signup">Sign up</button>
                </li>
            </ul>
        </form>
     </div>
</body>
</html>