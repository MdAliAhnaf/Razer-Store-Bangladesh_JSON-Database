<?php
session_start();
 if (!isset($_SESSION['username'])) {
        $_SESSION['username'] = "";
    }
/*$_SESSION['username'] = "";*/
/* if(count($_SESSION) === 0){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");
  }*/
  if($_SESSION['username'] === ""){

    
    header("Location: ../views/Login.php");
  }

  /*header("Location: ../controller/Logout.php");*/
   /* echo"<script>
                     
                     window.location.href='../views/Login.php';
                     </script>";*/

function userInfo($data)
    {
        if (file_exists("../model/Data.json")) 
{
            $current_data = file_get_contents("../model/Data.json");

            $current_data = json_decode($current_data, true);
            foreach ($current_data as $row) {
                if ($_SESSION['username'] === $row['username']) {
                    $d_data = array(
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'username' => $row['username'],
                        'gender' => $row['gender'],
                        'dob' => $row['dob'],
                        'phone' => $row['phone'],
                        'preadd' => $row['preadd'],
                        'religion' => $row['religion'],
                    );
                    return $d_data;
                }
            }
        }
    }
    $data = file_get_contents("../model/Data.json");
    $data = json_decode($data, true);
    $name = "";

    $user = userInfo($name);
    $_SESSION['name'] = $user['name'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['preadd'] = $user['preadd'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <style type="text/css">
        .error {
            color: red;
        }
    </style> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
 <!--  bootstraps navbar layout -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../views/Home.php">Razer Store Bangladesh</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>  
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../views/index.php">Store</a>
        </li>          
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../views/Dashboard.php">User Dashboard</a>
        </li>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../views/View_profile.php">My Profile</a>
        </li>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../controller/edit_profile.php">Edit Profile</a>
        </li>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../controller/change_password.php">Change Password</a>
        </li>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../views/order_history.php">Order History</a>
        </li>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../controller/Logout.php">Sign Out</a>
        </li>

        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> -->
      </ul>
                  
              
              </div>
            </div>
          </div>
        </div> 
      </div>  
    </div>
  </div>
 <div>
        <?php
        $count=0;
          if(isset($_SESSION['cart']))
          {
            $count=count($_SESSION['cart']);
          }
        ?>
        <a href= "../views/mycart.php"class="btn btn-outline-success" type="submit">MY CART (<?php echo $count; ?>)</a> 
 </div>
</nav>
</body>
</html>