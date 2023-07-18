<?php 
require '../views/include_require/user_dashboard_header.php';
/*$Total = $_SESSION['grand_total'];*/
  /*session_start();*/
  if(count($_SESSION) === 0){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");

  }
  if($_SESSION['username'] === ""){

    header("Location: ../controller/Logout.php");
   
 header("Location: ../views/Login.php");
  }


      foreach ($_SESSION['cart'] as $key => $value) 
     { 
      $Order_ID=$Order_Details=$Price=$Quantity=$Total="";                     
      $Order_Details = $_SESSION['cart'];                 
      $Price = $value['Price'];                              
      $Quantity = $value['Quantity'];     
     }
     unset($_SESSION['cart']);
     echo"<script>
         alert('Order Placed');
         window.location.href='order_history.php';
         </script>";
?>
<?php

$message = '';

$nameErr = $emailErr = $genderErr = $dobErr = $phoneErr = $preaddErr = $relErr = "";
$name = $email = $gender = $dob = $phone = $religion = "";
$preadd = '';
$usernameErr = $passErr = $conpassErr = "";
$usernameError = $emailError = "";
$username = $pass = $conpass = "";


if (isset($_POST["checkout"])) 
{
  $username = $_SESSION['username'];
  $pay_method = ($_POST["pay_method"]);
    function test_input($data) 
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

    if (!empty($Item_Name) || !empty($Quantity) /*|| !empty($pass) || !empty($gender) || !empty($dob)*/) 
    {
  
      if(file_exists("../model/Data.json"))
          
                
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
                  $currentID = $json[count($json) - 1]->Order_ID;
                  for($i = 0; $i<count($json);$i++)
                  {
                    if($_SESSION['username'] === $json[$i]->username)
                    {
                      
                     
                      
                     /*header("Location: ../views/Dashboard.php");*/
                     /*echo"<script>
                     alert('Both Username & Email already Exists');
                     window.location.href='Sign_up.php';
                     </script>";*/
                    
                      /*$gender = ($_POST["gender"]);*/
                      
                      $json[$i]->Order_ID = $Order_ID + 1;
                      $json[$i]->payment_method = $pay_method;
                      $json[$i]->grand_total = $_SESSION['grand_total'];
                      $json[$i]->Order_Details = $Order_Details;                     
                      
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
                      echo "<br><b>Order Placed Successfully !</b>";
                    }
                  }

             else
                {
                  echo "<br><b>You have entered wrong Information for Updating your profile!</b><br>";
                }
            
                                             
        } 

        else 
        {
            $error = 'JSON File does not exits';
        }
    
       
}
?>