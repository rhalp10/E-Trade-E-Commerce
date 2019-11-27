<?php
include('../db.php');

if (isset($_POST['action'])) {
	if ($_POST['action'] == 'stock_view') {
		$stock_ID = $_POST['stock_ID'];
		$output = array();
		$statement = $conn->prepare(
			"SELECT * FROM `item_stocks` `itms`
			LEFT JOIN `item_details` `itmd` ON `itmd`.`item_ID` = `itms`.`item_ID`
			WHERE `stock_ID` = $stock_ID LIMIT 1"
		);

		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{	

			$output["item_name"] = $row["item_Name"];
			$output["stock_Qnty"] = $row["stock_Qnty"];
		
		}
		echo json_encode($output);
	}
	
	
	
}
?>