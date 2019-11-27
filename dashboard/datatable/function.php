<?php
function encryptIt($q)
{
  $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
  $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
  return ($qEncoded);
}

function decryptIt($q)
{
  $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
  $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
  return ($qDecoded);
}

function get_total_all_records($conn,$sql)
{
	
	$statement = $conn->prepare($sql);
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

function check_user_level($conn,$var)
{
	$statement = $conn->prepare("SELECT * FROM `user_level` WHERE `lvl_ID` = $var");
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$level_name = $row["lvl_Name"];
	}
	return $level_name;
}



function get_available_stocks($conn,$item_ID){
    
  
    $statement = $conn->prepare("SELECT sum(stock_Qnty) as stock_Qnty  FROM `item_stocks` WHERE item_ID = $item_ID");
    $statement->execute();
   
        $harvest = $statement->fetchAll();
          foreach ($harvest as $row) {
            $stock_Qnty = $row["stock_Qnty"];
        }
    $statement = $conn->prepare("SELECT sum(ord_Qnty) as ord_Qnty FROM `order_item` WHERE item_ID =  $item_ID");
    $statement->execute();

    $order = $statement->fetchAll();
        foreach ($order as $row) {
            $order_Qnty = $row["ord_Qnty"];
    }
    if (empty($stock_Qnty)) {
        $stock_Qnty = "0";
    }
    if (empty($order_Qnty)) {
        $order_Qnty = "0";
    }
      
   
   $available_stocks = $stock_Qnty - $order_Qnty;
   $available_stocks  = number_format($available_stocks ,2);
   $statement = $conn->prepare("UPDATE `item_details` SET `item_Stocks` = '$available_stocks' WHERE `item_ID` = $item_ID");
   $statement->execute();


    return $available_stocks;
}
function get_stocks_status($item_count){
    if ($item_count > 0 ) {
        $var =  '<button type="button" class="btn btn-success btn-sm">
          Available
        </button>';
    }
    else{
         $var =  '<button type="button" class="btn btn-danger btn-sm">
          Out of Stocks
        </button>';
    }
      return $var;
}




?>