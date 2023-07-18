<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <style type="text/css">
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php require 'include_require/header.php'; ?>
    <?php require 'Navbar.php'; ?>
    <?php
    /*session_start();*/
    if (isset($_SESSION['username']) && ($_SESSION['username']) != "") {
        header("location:Dashboard.php");
    }
    ?>
    <?php
    $nameErr = $passErr = "";
    $username = $pass = "";
    if (isset($_POST["submit"])) 
    {

        if (empty($_POST["username"])) 
        {
            $nameErr = "Name is required";
        } 
        else if (empty($_POST["password"])) 
        {
            $passErr = "pass is required";
        } 
        else 
        {
            $username = $_POST['username'];
            $file_data = file_get_contents("../model/Data.json");
            $file_data = json_decode($file_data, true);
            foreach ($file_data as $data) 
            {
                if ($data['username'] === $_POST['username'] and $data['password'] === $_POST['password']) 
                {
                    $_SESSION['username'] = $username;
                    header("location:Dashboard.php");

                    if (!empty($_POST['remember']))
                    {
                        setcookie("uname", $_POST['username'], time() + 10);
                        setcookie("pass", $_POST['password'], time() + 10);
                        $_SESSION['username'] = $username;
                    } 
                    else 
                    {
                        setcookie("uname", "");
                        setcookie("pass", "");
                        echo "Cookie not set";
                    }
                }
            }
        }
    }
    ?>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" novalidate>
        <fieldset>
            <legend><i>Login to your Account</i></legend>
            User Name: <input type="text" name="username" value="<?php if (isset($_COOKIE['uname'])) {
                                                                        echo $_COOKIE['uname'];
                                                                    } ?>">
            <span class="error">* <?php echo $nameErr ?></span>
            <br><br>
            Password: <input type="password" name="password" value="<?php if (isset($_COOKIE['pass'])) {
                                                                        echo $_COOKIE['pass'];
                                                                    } ?>">
            <span class="error">* <?php echo $passErr; ?></span>
            <br><br>
            <input type="checkbox" name="remember"> Remember me
            
            <a href="../controller/forget_password.php" class="btn btn-outline-warning" type="submit">Forgot Password?</a> 
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn btn-outline-dark">
            
        </fieldset>
    </form>


    <?php include 'include_require/footer.php'; ?>
</body>

</html>