<?php
require 'include_require/header.php';
/*$usernameError = true;
$emailError = true; */
$message = '';

$nameErr = $emailErr = $genderErr = $dobErr = $phoneErr = $preaddErr = $relErr = "";
$name = $email = $gender = $dob = $phone = $religion = "";
$preadd = '';
$usernameErr = $passErr = $conpassErr = "";
$usernameError = $emailError = "";
$username = $pass = $conpass = "";

if (isset($_POST["submit"])) 
{
    function test_input($data) 
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

    if (empty($_POST["name"])) 
    {
        $nameErr = "<label class='text-danger'>Name is required</label>";  
    } 
    else if (!empty($_POST["name"])) 
    {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) 
        {
            $nameErr = "<label class='text-danger'>Only letters and white space is allowed</label>"; 
            $name = "";
        } 
        else if (strlen($name) < 2) 
        {
            $nameErr = "<label class='text-danger'>Must contain at least two  words</label>"; 
            $name = "";
        }
    }

    if (empty($_POST["email"])) 
    {
        $emailErr = "<label class='text-danger'>Email is required</label>"; 
    } 
    else if (!empty($_POST["email"])) 
    {
        $email = ($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $emailErr = "<label class='text-danger'>Invalid email format</label>"; 
            $email = "";
        }
    }
    if (empty($_POST["username"])) 
    {
        $usernameErr = "<label class='text-danger'>User Name is required</label>"; 
    } 
    else if (!empty($_POST["username"])) 
    {
        $username = ($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-'_]*$/", $username)) 
        {
            $usernameErr = "<label class='text-danger'>Only letters and underscores are allowed</label>"; 
            $username = "";
        } 
        else if (strlen($username) < 3) 
        {
            $usernameErr = "<label class='text-danger'>Must contain at least three  words</label>"; 
            $username = "";
        }
        else if(strlen($username) >= 9)
        {
            $usernameErr = "<label class='text-danger'>Cannot exceed more than eight words</label>"; 
            $username = "";
        }

    }

    if (empty($_POST["password"])) 
    {
        $passErr = "<label class='text-danger'>Password is required</label>"; 
    } 

    else if (!empty($_POST["password"]) && ($_POST["password"] == $_POST["confirmpassword"])) 
    {
        $pass = ($_POST["password"]);
        if (strlen($pass) < 8) 
        {
            $passErr = "<label class='text-danger'>Password cannot be less than eight (8) characters</label>"; 
            $pass = "";
        } 
        else if (!preg_match("#[0-9]+#", $pass)) 
        {
            $passErr = "<label class='text-danger'>Password Must Contain At Least 1 Number!</label>"; 
            $pass = "";
        }
        else if (!preg_match("#[A-Z]+#", $pass)) 
        {
            $passErr = "<label class='text-danger'>Password Must Contain At Least 1 Capital Letter!</label>"; 
            $pass = "";
        }
        else if (!preg_match("#[a-z]+#", $pass)) 
        {
            $passErr = "<label class='text-danger'>Password Must Contain At Least 1 Lowercase Letter!</label>"; 
            $pass = "";
        }
        else if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pass)) {
            $passErr = "<label class='text-danger'>Must contain at least one of the special characters \'^£$%&*()}{@#~?><>,|=_+¬- </label>"; 
            $pass = "";
        }
    }

    if (empty($_POST["confirmpassword"])) 
    {
        $conpassErr = "<label class='text-danger'>This field is required</label>"; 
    } 
    else if (!empty($_POST["confirmpassword"])) 
    {
        if ($_POST["password"] == $_POST["confirmpassword"]) 
        {
            $conpass = $_POST["confirmpassword"];
        } 
        else 
        {
            $conpassErr = "<label class='text-danger'>Password doesn't matches</label>"; 
        }
    }
    if (empty($_POST["gender"])) 
    {
        $genderErr = "Gender is required";
    } 
    else if (!empty($_POST["gender"])) 
    {
        $gender = ($_POST["gender"]);
    }

    if (empty($_POST["dob"])) 
    {
        $dobErr = "cannot be empty";
    } 
    else if (!empty($_POST["dob"])) 
    {
        $dob = ($_POST["dob"]);
    }


    if (empty($_POST["phone"])) 
    {
        $phoneErr = "<label class='text-danger'>Phone Number is required</label>";  
    } 
    else if (!empty($_POST["phone"])) 
    {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[0-9]{3}[0-9]{4}[0-9]{4}$/", $phone)) 
        {
            $phoneErr = "<label class='text-danger'>Phone number can only have valid 11 digits</label>"; 
            $phone = "";
        } 
    }

    if (empty($_POST["preadd"])) 
    {
        $preaddErr = "<label class='text-danger'>Current Address is required</label>";  
    } 
    else if (!empty($_POST["preadd"])) 
    {
        $preadd = test_input($_POST["preadd"]);
        $preadd = ''; 
    }

    if (empty($_POST["religion"])) 
    {
        $relErr = "<label class='text-danger'>Religion is required</label>";  
    } 
    else if (!empty($_POST["religion"]) && ($_POST["religion"])==="Islam"||"Christianity"||"N/A"||"Hinduism" ||"Buddhism" ||"Folk religions" ||"Sikhism" || "Judaism") 
    {
        $religion = test_input($_POST["religion"]);
        $religion = ""; 
    }

    if (!empty($name) && !empty($email) && !empty($pass) && !empty($conpass) && !empty($gender) && !empty($dob) && !empty($phone)) 
    {
        /*session_start();*/
        
        define("FILENAME", "../model/Data.json"); //define filename
        $file1 = fopen(FILENAME, "r"); //opened the file in only read mode
        $fr = fread($file1, filesize(FILENAME));//reading the file and storing in $fr
        $json = json_decode($fr);//decoding the content not mandatory if there is any content in the file or not
        fclose($file1);//close the file
        if (file_exists('../model/Data.json'))  //if data.json file exists
        {
            
            $flag = true;
            for($i=0; $i<count($json); $i++)
            {
                if($json[$i]->username === $username && $json[$i]->email === $email)
                {
                    $usernameError = true;
                    $emailError = true; 
                    echo"<script>
                     alert('Both Username & Email already Exists');
                     window.location.href='Sign_up.php';
                     </script>";
                }
                if($json[$i]->username === $username)
                {
                    $flag = false;
                    $usernameError = true;
                     echo"<script>
                     alert('Username already Exists');
                     window.location.href='Sign_up.php';
                     </script>";   
                    /*echo '<script>alert("Username already Exists")</script>'; */
                    break;                                       
                }
                if($json[$i]->email === $email)
                {
                  $flag = false;
                  $emailError = true; 
                  echo"<script>
                     alert('Email already Exists');
                     window.location.href='Sign_up.php';
                     </script>"; 
                  break;                  
                }
                /*if($usernameError==false && $emailError==false)
                {
                   header("location:../views/Login.php");
                }*/

            }

            if($flag)
            {
              $usernameError = false;
              $emailError = false; 
              $currentID = $json[count($json) - 1]->id;
              $file2 = fopen(FILENAME,"w"); //opening the file for write mode only & vanishin previous contents of the file
                      
              $data = array(
                "id"          =>    $currentID + 1,
                'name'          =>     $name,
                'email'           =>     $email,
                'username'          =>     $username,
                'password'            =>     $pass,
                'gender'                =>     $gender, 
                'dob'                     =>     $dob,              
                'phone'                     =>     $phone,
                'preadd'                      =>     $_POST["preadd"],
                'religion'                      =>     $_POST["religion"],
                'Order_ID'                        =>     "",
                'payment_method'                    =>     "",
                'Order_Details'                        =>     "",
                'grand_total'                             =>     ""
              );

              if($json === NULL) //if there is no data in the file which $json stored
              {
                $data = array($data); //data get binded in the array and stored in $data
                $data = json_encode($data); //then gets encoded
                fwrite($file2, $data); //then write in the $file2 file
              }
              else //if there is data in $json
              {
                  $json[]=$data; //$json becomes an array of php then in the last index of $json[] the data of $data is inserted
                  $data = json_encode($json); //json encoding to convert and put the file in Data.json
                  fwrite($file2, $data); //then write in the $file2 file
              }
              fclose($file2);
            
              if (file_put_contents('../model/Data.json', $data) && $usernameError==false && $emailError==false)  //if the contents are successfully put in data,json message ouyputs success 
              {
                echo"<script>
                     alert('You Successfully Signed up');
                     window.location.href='login.php';
                     </script>";
                 /*header("location:../views/Login.php");*/
                  /*$message = "<label class='text-success'>Sign up was Successful</p>"; */
              }
            }

        } 

        else 
        {
            $error = 'JSON File does not exits';
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Sign up Razer Store</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     
     <style type="text/css">
        h1 {text-align: center;}
        .error {
            color: red;
        }
     </style>
</head>
<body>
<img src="razer_team.png" alt="Razer Team Logo" align="center" width="300.975" height="75">
    <h1 align=""><i>Sign Up to Razer Store Bangladesh</i> </h1><br />
    
    <div class="container" style="width:500px;">                   
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" novalidate>
        <?php
        /*if($usernameError==true)
        {
            echo "Username Already Exists";
        }
        ?>
        <br><br>
        <?php              
        if ($emailError==true)
        {
                echo "Email Already Exists";
               
        }
           */           
        if (isset($error)) 
        {
            echo $error;
        }
        ?>

        <br>
        <label for = "name">Name</label>  
        <input type="text" name="name" id="fullname"  placeholder= "Please write your full name" size="25" autofocus class="form-control" value="<?php echo $name; ?>">
        <span class="error">* <?php echo $nameErr; ?></span>
        <br>
        <label>E-mail</label>
        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br>
        <label>User Name</label>
        <input type="text" name="username" id = "user_name" placeholder= "Username must be between 3 to 8 words" class="form-control" value="<?php echo $username; ?>">
        <span class="error">* <?php echo $usernameErr; ?></span>
        <br>
        <label>Password</label>
        <input type="text" name="password" class="form-control"> 
        <span class="error">* <?php echo $passErr; ?></span>
        <br>
        <label>Confirm password</label>
        <input type="text" name="confirmpassword" class="form-control">
        <span class="error">* <?php echo $conpassErr; ?></span>
        <br>
        <fieldset>
            <legend><i>Gender</i></legend>
            <input type="radio" id="Male" name="gender" value="Male">
            <label for="Male">Male</label>
            <input type="radio" id="Female" name="gender" value="Female">
            <label for="Female">Female</label>
            <input type="radio" id="other" name="gender" value="Other">
            <label for="Other">Other</label>
            <br>
            <span class="error">* <?php echo $genderErr; ?></span>
            <br><br>
            <legend><i>Date of Birth</i></legend>
            <input type="date" id="dob" name="dob">
            <br>
            <span class="error">* <?php echo $dobErr; ?></span>
            <br><br>

           
            
        </fieldset>
        <fieldset>
            <legend><b>Contact Information:</b></legend>

            <label for = "phone">Phone Number</label>
                        <input type="tel" id="phone" name = "phone" placeholder= "Number must contain 11 digits" size="23" class="form-control" value="<?php echo $phone; ?>">
        <span class="error">* <?php echo $phoneErr; ?></span>
        <br><br>
                         

            <label for = "preadd">Present Address</label>                   
                        <br>                        
                        <textarea name="preadd" id="preadd" placeholder= "Please write your current address" rows="2" cols="50" class="form-control" value="<?php echo $preadd; ?>"></textarea>
                        <span class="error">* <?php echo $preaddErr; ?></span>
                        <br><br>

            </fieldset>

             <label for = "religion">Religion</label>
                        <select name="religion" class="form-control">
                             <option value="Islam">Islam</option>
                             <option value="Christianity">Christianity</option>
                             <option value="N/A">N/A</option>
                             <option value="Hinduism">Hinduism </option>
                             <option value="Buddhism">Buddhism</option>
                             <option value="Folk Religion">Folk Religion</option>
                             <option value="Sikhism">Sikhism</option>
                             <option value="Judaism">Judaism</option>                            
            <br><br>

        <input type="submit" name="submit" value="Sign Up" class="btn btn-info" /><br />
        <br>
        <input type="reset" name="reset" value="RESET" class="btn btn-outline-danger">
        <?php
        if (isset($message)) 
        {
            echo $message;
        }
        ?>
    </form>
    </div>
    <br />
    <?php include '../views/include_require/footer.php'; ?>
</body>
</html>