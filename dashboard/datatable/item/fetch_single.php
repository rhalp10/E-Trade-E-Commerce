<?php
include('../db.php');

if (isset($_POST['action'])) {
	if ($_POST['action'] == 'item_view') {
		$item_ID = $_POST['item_ID'];
		$output = array();
		$statement = $conn->prepare(
			"SELECT * FROM `item_details` WHERE item_ID = $item_ID LIMIT 1"
		);

		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{			
		
			
			if (!empty($row['item_Img'])) {
				
			 $output["item_Img"] = 'data:image/jpeg;base64,'.base64_encode($row['item_Img']);
			}
			else{
			  $output["item_Img"] = "../assets/img/uploads/blank.png";
			}

			$output["item_Name"] = $row["item_Name"];
			$output["ctgy_ID"] = $row["ctgy_ID"];
			$output["item_Description"] = $row["item_Description"];
			$output["item_Price"] = $row["item_Price"];
			$output["item_Weight"] = $row["item_Weight"];
			$output["item_Stocks"] = $row["item_Stocks"];
			$output["item_NewPrice"] = (0.1 * $row["item_Price"])+$row["item_Price"];
		
		}
		echo json_encode($output);
	}
	
	
	
}
?>