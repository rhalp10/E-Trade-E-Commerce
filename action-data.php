<?php 
include('dbconfig.php');

if (isset($_POST['action'])) {

	if ($_POST['action'] == "product_view") {

    $output = array();
    $item_ID = $_POST['data_id'];
    $sql = "SELECT * FROM `item_details` WHERE item_ID = $item_ID";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
    $output["item_Name"] = $row["item_Name"];
    if (!empty($row['item_Img'])) {
     $output["item_Img"] = 'data:image/jpeg;base64,'.base64_encode($row['item_Img']);
    }
    else{
      $output["item_Img"] = "";
    }
    
    $output["item_Name"] = $row["item_Name"];
    $output["item_Description"] = $row["item_Description"];
    $output["item_Price"] = (0.1*$row["item_Price"]);
    $output["item_Qnty"] = $row["item_Stocks"];
    }
  
    echo json_encode($output);
    
  }
  if ($_POST['action'] == "checkout") {
    session_start();
    $output = array();
    if (isset($_SESSION['login_user'])) {

      $or_ID = $_POST["or_ID"];
      $sql = "UPDATE `order` SET `ors_ID` = '1' WHERE `order`.`or_ID` = $or_ID;";
      $result = mysqli_query($conn, $sql);
      $output['msg'] = "Successfully Placed";
      $output['success'] = "Error";
    }
    else{
      $output['msg'] = "You Need to register First";
      $output['error'] = "Error";
    }
    echo json_encode($output);
  }

  if ($_POST['action'] == "addtoCart") {
    session_start();
    $output = array();
    if (isset($_SESSION['login_user'])) {
      $login_id = $_SESSION["login_id"];
       $query = mysqli_query($conn,"SELECT * FROM `order` WHERE user_ID = $login_id  AND ors_ID = 0");
      if (mysqli_num_rows($query) > 0) 
      {
        $rows = mysqli_fetch_assoc($query);
        $or_ID = $rows["or_ID"];
      }
      else{
        $sql = "INSERT INTO `order` (`or_ID`, `user_ID`, `or_Date`, `ors_ID`) VALUES (NULL, $login_id, CURRENT_TIMESTAMP, 0);";
          $result = mysqli_query($conn, $sql);
          $or_ID = mysqli_insert_id($conn);
        }
        
        $item_ID = $_POST["item_ID"];
        $item_qty = $_POST["item_qty"];
        
        $sql = "SELECT item_Price FROM `item_details`  WHERE item_ID = $item_ID ";


        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
          $item_Price = $row['item_Price'];
        }
        $subtotal = ((0.1 * $item_Price)+$item_Price) * $item_qty;
        $sql = "INSERT INTO `order_item` (`ord_ID`, `or_ID`, `item_ID`, `ord_Qnty`, `ord_Price`, `ord_Date`) VALUES (NULL, $or_ID, $item_ID, $item_qty, $subtotal, CURRENT_TIMESTAMP);";
        $result = mysqli_query($conn, $sql);

        $output['msg'] = "Success Added";
        $output['success'] = "Success";
      }
      else{
        $output['msg'] = "You Need to register First";
        $output['error'] = "Error";
      }
      echo json_encode($output);
      
    }

	 if ($_POST['action'] == "removeitemtoCart") {
      $output = array();
      $ord_ID = $_POST["data_id"];
      $sql = "DELETE FROM `order_item` WHERE `order_item`.`ord_ID` = $ord_ID";
      
      if ( mysqli_query($conn, $sql)) {
          $output['msg'] = "Successfuly Remove";
      }
      else{
        $output['msg'] = "Error in Remove";
      }
      echo json_encode($output);
    }
	if ($_POST['action'] == "fetch_items") {

		if(isset($_REQUEST['search'])){
			$search_query = $_POST['search'];
			$search  = "WHERE item_Name LIKE '%$search_query%'";
		}
		else{
			$search = "";
		}

      $sql = "SELECT * FROM `item_details` ".$search ;
      $result = mysqli_query($conn, $sql);
      $count_question = mysqli_num_rows($result) ;
     
      ?>
      <div class="row">
        <?php 
         if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
        $item_ID = $row['item_ID'];
      if (!empty($row['item_Img'])) {
        
        $prod_Img = 'data:image/jpeg;base64,'.base64_encode($row['item_Img']);
      }
      else{
        $prod_Img = "assets/img/uploads/blank.png";
      }
        $prod_Name = $row['item_Name'];
        $prod_Qnty = $row['item_Stocks'];
        
    
        if ($prod_Qnty > 0) {
          $av = "<label  class='btn btn-success btn-sm float-right'>Available</label>";
        }
        else{
           $av = "<label class='btn btn-danger btn-sm float-right'>Out of Stock</label>";
        }
         ?>

          <div class="col-md-4">
          <div class="card mb-4 shadow-sm" >
            <div  class="bd-placeholder-img card-img-top img-fluid"  width="100%" height="100%" style="background-image: url('<?php echo $prod_Img?>');
               background-size: cover;
               background-repeat: no-repeat; height:278px; width:278px;" ></div>
            <div class="card-body" style="min-height: 125px;">
              <p class="card-text" >
              <strong><?php echo $prod_Name?><?php echo $av?></strong>
              <br>
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ActionModal"  data-id="<?php echo $item_ID?>" id="view_prod">View</button>
                  <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ActionModal"  data-id="<?php echo $item_ID?>" id="addcart_prod">Add to Cart</button>
                </div>
                
              </div>
            </div>
          </div>
        </div>
   
         <?php
            }
          }
          else{
          	?>
		    <h1 style="margin-left:150px !important; padding: 5px; color: white;">No Item Available</h1>
          	<?php
          	
          }
			
	}	
	
}

?>