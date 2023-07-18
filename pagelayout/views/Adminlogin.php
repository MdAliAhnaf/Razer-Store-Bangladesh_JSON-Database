<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <title>Login</title>
    <style type="text/css">
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php include 'include_require/header.php'; ?>
    <?php require 'Navbar.php'; ?>
    <?php
    /*session_start();*/
    if (isset($_SESSION['adminname'])) {
        header("location:AdminPanel.php");
    }
    ?>

    <?php
    $adminnameErr = $adminpassErr = "";
    $adminname = $pass = "";
    if (isset($_POST["submit"])) 
    {

        if (empty($_POST["adminname"])) 
        {
            $adminnameErr = "Name is required";
        } 
        else if (empty($_POST["adminpassword"])) 
        {
            $adminpassErr = "pass is required";
        } 
        else 
        {
            $adminname = $_POST['adminname'];
            $file_data = file_get_contents("../model/admin_data.json");
            $file_data = json_decode($file_data, true);
            foreach ($file_data as $data) 
            {
                if ($data['adminname'] === $_POST['adminname'] and $data['adminpassword'] === $_POST['adminpassword']) 
                {
                    $_SESSION['adminname'] = $adminname;
                    header("location:AdminPanel.php");

                    if (!empty($_POST['remember'])) 
                    {
                        setcookie("aname", $_POST['adminname'], time() + 10);
                        setcookie("pass", $_POST['adminpassword'], time() + 10);
                        $_SESSION['adminname'] = $adminname;
                    } 
                    else 
                    {
                        setcookie("aname", "");
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
            <legend>LOGIN</legend>
            Admin Name: <input type="text" name="adminname" value="<?php if (isset($_COOKIE['aname'])) {
                                                                        echo $_COOKIE['aname'];
                                                                    } ?>">
            <span class="error">* <?php echo $adminnameErr ?></span>
            <br><br>
            Password: <input type="password" name="adminpassword" value="<?php if (isset($_COOKIE['pass'])) {
                                                                        echo $_COOKIE['pass'];
                                                                    } ?>">
            <span class="error">* <?php echo $adminpassErr; ?></span>
            <br><br>
            <input type="checkbox" name="remember"> Remember me
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn btn-outline-dark">
            <!-- <a href="Forgot_password.php">Forgot Password?</a> -->
        </fieldset>
    </form>


    <?php require 'include_require/footer.php'; ?>
</body>

</html>