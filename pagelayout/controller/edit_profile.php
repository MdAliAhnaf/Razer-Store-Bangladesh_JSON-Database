<?php 

require '../views/include_require/user_dashboard_header.php';
  /*session_start();*/
  if(count($_SESSION) === 0){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");

  }
  if($_SESSION['username'] === ""){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");
  }


?>

<?php

$message = '';

$nameErr = $emailErr = $genderErr = $dobErr = $phoneErr = $preaddErr = $relErr = "";
$name = $email = $gender = $dob = $phone = $religion = "";
$preadd = '';
$usernameErr = $passErr = $conpassErr = "";
$usernameError = $emailError = "";
$username = $pass = $conpass = "";


if (isset($_POST["submit"])) 
{
    if (empty($name) || empty($email) ||empty($pass) || empty($gender) || empty($dob) || empty($phone)) 
    {
        $nameErr = "<label class='text-danger'>Name is required</label>";
        $genderErr = "Gender is required";
        $dobErr = "cannot be empty";
        $phoneErr = "<label class='text-danger'>Phone Number is required</label>";
        $preaddErr = "<label class='text-danger'>Current Address is required</label>";
        $relErr = "<label class='text-danger'>Religion is required</label>";  
    }
  $username = $_SESSION['username'];
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
    $name = test_input($_POST["name"]);
    if ((preg_match("/^[a-zA-Z-' ]*$/", $name)) && !empty($_POST["name"]))
    {       
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) 
        {
            $nameErr = "<label class='text-danger'>Only letters and white space is allowed</label>"; 
            $name = "";
        } 
        if (strlen($name) < 2) 
        {
            $nameErr = "<label class='text-danger'>Must contain at least two  words</label>"; 
            $name = "";
        }
        if (empty($_POST["gender"])) 
        {
        $genderErr = "Gender is required";
        
        } 
        if (!empty($_POST["gender"])) 
        {
        $gender = ($_POST["gender"]);
        if (empty($_POST["dob"])) 
    {
        $dobErr = "cannot be empty";
        
    } 
    if (!empty($_POST["dob"])) 
    {
        $dob = ($_POST["dob"]);
           if (empty($_POST["phone"])) 
    {
        $phoneErr = "<label class='text-danger'>Phone Number is required</label>";  
        
    } 
    if (!empty($_POST["phone"])) 
    {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[0-9]{3}[0-9]{4}[0-9]{4}$/", $phone)) 
        {
            $phoneErr = "<label class='text-danger'>Phone number can only have valid 11 digits</label>"; 
            $phone = "";
        }
        if (empty($_POST["preadd"])) 
    {
        $preaddErr = "<label class='text-danger'>Current Address is required</label>";
        
    } 
    if (!empty($_POST["preadd"])) 
    {
        $preadd = test_input($_POST["preadd"]);
        $preadd = '';
        if (empty($_POST["religion"])) 
    {
        $relErr = "<label class='text-danger'>Religion is required</label>";  
        
    } 
    if (!empty($_POST["religion"]) && ($_POST["religion"])==="Islam"||"Christianity"||"N/A"||"Hinduism" ||"Buddhism" ||"Folk religions" ||"Sikhism" || "Judaism") 
    {
        $religion = test_input($_POST["religion"]);
        $religion = "";


if (!empty($name) || !empty($email) || !empty($pass) || !empty($gender) || !empty($dob) || !empty($phone)) 
    {
      if(file_exists("../model/Data.json"))
          {
       
                
                define("FILENAME", "../model/Data.json"); //define filename
                $file1 = fopen(FILENAME, "r"); //opened the file in only read mode
                $fr = fread($file1, filesize(FILENAME));//reading the file and storing in $fr
                $json = json_decode($fr);//decoding the content not mandatory if there is any content in the file or not
                fclose($file1);//close the file

                $loginFlag = false;
                for($i=0; $i<count($json); $i++)
                {

                  if($json[$i]->username === $username)
                  {           
                    $loginFlag = true;
                    break;
                  }              
                }

            
               if($loginFlag)
                {
                  for($i = 0; $i<count($json);$i++)
                  {
                    if($_SESSION['username'] === $json[$i]->username)
                    {
                      
                      $json[$i]->name = $name;
                      /*$emailflag = true;
                      if($json[$i]->email === $email)
                      {
                        $emailflag = false;                  
                        echo"<script>
                     alert('Email already Exists');
                     window.location.href='edit_profile.php';
                     </script>";
                        break;
                      }

                      if($emailflag==true)
                      {
                        header("Location: ../views/Dashboard.php");
                      }
                      
                      if($emailflag)
                      {
                        $json[$i]->email = $email;
                      }*/
                      
                      $json[$i]->gender = $gender;
                      $json[$i]->dob = $dob;
                      $json[$i]->phone = $phone;
                      $json[$i]->preadd = $_POST["preadd"];
                      $json[$i]->religion = $_POST["religion"];

                      $file2 = fopen(FILENAME,"w");
                      $data='';
                       /*$data = array('password'         =>    $password);*/
                                                                      
                    }
                  }

                  /*if($json === NULL)
                        {
                          $data = array($data); //data get binded in the array and stored in $data
                          $data = json_encode($data); //then gets encoded
                          fwrite($file2, $data); //then write in the $file2 file
                        }*/
                       
                       if($json !== NULL)
                        {
                           /*$json[]=$json;*/ //$json becomes an array of php then in the last index of $json[] the data of $data is inserted
                          $json= json_encode($json); //json encoding to convert and put the file in Data.json
                          fwrite($file2, $json); //then write in the $file2 file
                        }
                        fclose($file2);
            
                    if (file_put_contents('../model/Data.json', $json))  //if the contents are successfully put in data,json message ouyputs success 
                    {
                      echo"<script>
                     alert('Profile updated Successfully !');
                     window.location.href='../views/View_profile.php';
                     </script>";
                    }
                  }

                  else
                  {
                    echo"<script>
                     alert('Username doesn't match');
                     window.location.href='../controller/edit_profile.php';
                     </script>";
                  }
              }

              
          }

             else
                {
                    echo"<script>
                     alert('JSON File does not exists!');
                     window.location.href='../controller/edit_profile.php';
                     </script>";
                     $error = 'JSON File does not exists';
                    
                }
            
                                                 

        } 

        else 
        {
                     /*echo"<script>
                     alert('Enter Valid Information in all fields!');
                     window.location.href='../controller/edit_profile.php';
                     </script>";*/
            
        }

    } 

    }
 
    }

    }
  
        }
  else 
        {
                     $nameErr = "<label class='text-danger'>Only letters and white space is allowed</label>"; 
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Edit Profile Details</title>
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
<img src="../views/razer_team.png" alt="Razer Team Logo" align="center" width="300.975" height="75">
    <h1 align=""><i>Update Profile Details</i> </h1><br />
    
    <div class="container" style="width:500px;">                   
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" novalidate>
        <?php
               
        if (isset($error)) 
        {
            echo $error;
        }
        ?>

        <br>
        <label for = "name">Name</label>  
        <input type="text" name="name" id="fullname"  placeholder= "Please write your full name" size="25" autofocus class="form-control" value="<?php echo $_SESSION['name']; ?>">
        <span class="error">* <?php echo $nameErr; ?></span>
        <br>
        <!-- <label>E-mail</label>
        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br> -->
        <!-- <label>User Name</label>
        <input type="text" name="username" id = "user_name" placeholder= "Username must be between 3 to 8 words" class="form-control" value="<?php echo $username; ?>">
        <span class="error">* <?php echo $usernameErr; ?></span>
        <br>
        <label>Password</label>
        <input type="text" name="password" class="form-control"> 
        <span class="error">* <?php echo $passErr; ?></span>
        <br> -->
        
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
                        <input type="tel" id="phone" name = "phone" placeholder= "Number must contain 11 digits" size="23" class="form-control" value="<?php echo $_SESSION['phone']; ?>">
        <span class="error">* <?php echo $phoneErr; ?></span>
        <br><br>
                         

            <label for = "preadd">Present Address</label>                   
                        <br>                        
                        <textarea name="preadd" id="preadd" placeholder= "Please write your current address" rows="2" cols="50" class="form-control" value="<?php echo $_SESSION['preadd']; ?>"></textarea>
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
                             <span class="error">* <?php echo $relErr; ?></span>
                        <br><br>                            
            <br><br>
        <br><br>
        <input type="submit" name="submit" value="Update Information" class="btn btn-info" /><br />
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