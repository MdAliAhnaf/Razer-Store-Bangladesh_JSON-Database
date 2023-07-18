<?php 
require '../views/include_require/user_dashboard_header.php';
 if($_SESSION['username'] === ""){

    header("Location: ../controller/Logout.php");
   
 header("Location: ../views/Login.php");
  }
  
if(count($_SESSION) === 0){

    header("Location: ../controller/Logout.php");
    header("Location: ../views/Login.php");

  }
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Order History</title> 
  <style type="text/css">
        h1 {text-align: center;}
        .error {
            color: red;
        }
     </style>  
</head>
<body>
	 <div class = "container">
	  <div class = "row">
       <div class = "col-lg-12 text-center border rounded bg-light my-5">
     	<h1>Order History</h1>
      </div>

     <div class = "col-lg-9">
<table class="table">
  <thead class ="text-center">
    <tr>
      <th scope="col">Order No#</th>
      <th scope="col">Order Details</th>
      <!-- <th scope="col">Item Price</th>
      <th scope="col">Quantity</th> -->
      <th scope="col">Grand Total</th>
      <th scope="col">Payment Method</th>
    </tr>
  </thead>
  <tbody class ="text-center">
  	<?php
  	/*$total=0;*/
  	function userHistory($data)
    {
        if (file_exists("../model/Data.json")) 
{
            echo "Hey, " . "<b><i>".$_SESSION['username'] . "</b></i>";
            $current_data = file_get_contents("../model/Data.json");

            $current_data = json_decode($current_data, true);
            foreach ($current_data as $row) {
                if ($_SESSION['username'] === $row['username']) {
                    $d_data = array(
                        'Order_ID' => $row['Order_ID'],
                        'payment_method' => $row['payment_method'],
                        'Order_Details' => json_encode($row['Order_Details']),
                        'grand_total' => $row['grand_total'],
                        'preadd' => $row['preadd'],

                        /*'Order_ID' => $row['Order_ID'],
                        'Order_ID' => $row['Order_ID'],*/                   
                    );
                    return $d_data;
                }
            }
        }
    }
    $data = file_get_contents("../model/Data.json");
    $data = json_decode($data, true);
    $Order_ID = "";
    $user = userHistory($Order_ID);
    $Order_ID = $user['Order_ID'];
    $pay_method = $user['payment_method'];
    $Order_Details = $user['Order_Details'];
    $grand_total = $user['grand_total'];
    $preadd  = $user['preadd'];

    /*$sr=0;
*/

   /* foreach ($data as $row)
    {
       if($Order_Details==$row['Item_Name'])
       {
         $Item_Name=$Order_Details['Item_Name'];
       }

    }*/

  	foreach ($data as $row)
     {
  	  	/*$sr=($sr+1)*/; //index no. +1 increment Serial No. Increasing after adding items through array index
  		echo"
        <tr>
             <td>
             $Order_ID
             </td>

             <td>
             $Order_Details
             </td>

             <td>
             $grand_total
             </td> 
             <td>
             $pay_method
             </td>

             <br>
        </tr>

        <tr>
        <b>Shipping Address:</b> 
        $preadd 
        </tr>";
	

  	  }
    
?> 
  </tbody>
</table>
      </div>
     </div>
    </div>
</body>
</html>
<?php include '../views/include_require/footer.php'; ?>