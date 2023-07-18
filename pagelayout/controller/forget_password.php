<?php 
require '../views/include_require/header.php';
  /*session_start();*/

/*  if(count($_SESSION) === 0){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");
  }
  if($_SESSION['username'] === ""){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");
  }*/


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RESET Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
 <!--  <p>Welcome, Your username: <b> <?php /*echo $_SESSION['username'];*/ ?> </b></p><hr> -->
  <!-- <p>    <a href="../views/Home.php">Home</a>   |  <a href="Logout.php">Logout</a></p><hr> -->

  <h2>Recover Password</h2><hr>

  <fieldset>
    <legend>Enter Valid Credentials</legend>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
         <br>
         <label> User Name:</label>
         <input type="text" name="username" id = "user_name" autofocus>
          <br><br>
          <label>Current/Old password: </label>
          <input type="password" name="OldPassword" >
          <br><br>

          <label>New password: </label>
          <input type="password" name="password">
          <br><br>

          <label>Confirm password: </label>
          <input type="password" name="conPassword">
          <br><br>

          <input type="submit" name="change_password" value="Change Password" class="btn btn-outline-danger">
      </form>
      <br>
      <?php 

        if($_SERVER['REQUEST_METHOD'] === "POST")
        {

          $username = $_POST['username'];
          $password = $_POST['password'];
          $conPassword = $_POST['conPassword'];
          $oldPassword = $_POST['OldPassword'];


          if(empty($conPassword) or empty($password) or empty($oldPassword) or empty($username))
          {
            echo "<br><b>Please fill up proper information.</b>";
          }
          else 
          {

            if(strlen($password) < 8 ) 
            {
              echo "<br>Password must be at least <b>8 characters</b> in length.</br>";
            }

            else if($conPassword !== $password) 
            {
              echo "<br><b>New password and confirm password doesn't match.</b></br>";
            }

             else if(!preg_match("#[0-9]+#", $password))
            {
              echo "<br><b>Password Must Contain At Least 1 Number!</b></br>";
            }

            else if(!preg_match("#[A-Z]+#", $password))
            {
              echo "<br><b>Password Must Contain At Least 1 Capital Letter!</b></br>";
            }

            else if(!preg_match("#[a-z]+#", $password))
            {
              echo "<br><b>Password Must Contain At Least 1 Lowercase Letter!</b></br>";
            }

            else if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$password))
            {
              echo "<br><b>Must contain at least one of the special characters \'^£$%&*()}{@#~?><>,|=_+¬- </b></br>";
            }

            else
            {  $x = "zz";
              if(file_exists("../model/Data.json"))
              {
                /*header("location:Login.php");*/
                define("FILENAME", "../model/Data.json"); //define filename
                $file1 = fopen(FILENAME, "r"); //opened the file in only read mode
                $fr = fread($file1, filesize(FILENAME));//reading the file and storing in $fr
                $json = json_decode($fr);//decoding the content not mandatory if there is any content in the file or not
                fclose($file1);//close the file

                $loginFlag = false;

                for($i=0; $i<count($json); $i++)
                {
                  if($json[$i]->username ===  $username && $json[$i]->password === $oldPassword)
                  {
                    $loginFlag = true;
                    break;
                  } 
                  
                  
                    if($json[$i]->username !== $username)
                    {
                     $x = "aa";
                     $loginFlag = false; 
                     echo "Username doesn't Exists";
                     break;      
                    }
                
                                
                }
             
                if($loginFlag)
                {
                  for($i = 0; $i<count($json);$i++)
                  {
                    if($username === $json[$i]->username)
                    {
                      
                      $json[$i]->password = $password;
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
                      echo "<br><b>Password is changed Successfully!</b>";
                    }
                  }

             else if($x == "zz")
                {   
                  echo "<br><b>You have entered wrong password,Enter current password in the following Current/Old password field!</b><br>";
                   } 
                             
                }
              else
              {
                echo "json file not found!";
              }
            }
          }
        }
      ?>
  </fieldset>

<?php include '../views/include_require/footer.php'; ?>


</body>
</html>