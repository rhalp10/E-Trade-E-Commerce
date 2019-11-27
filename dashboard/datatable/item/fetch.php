<?php
include('../db.php');
include('../function.php');
session_start();
$query = '';
$output = array();
$query .= "SELECT *";
$query .= " FROM `item_details` `item`
LEFT JOIN `item_category` `ctgy` ON `item`.`ctgy_ID` = `ctgy`.`ctgy_ID`";

$query .=  "WHERE item.user_ID = '".$_SESSION['login_id']."' AND";

if(isset($_POST["search"]["value"]))
{
 $query .= '(item_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR item_Name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR ctgy_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY item_ID ASC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	
	$available_stocks = get_available_stocks($conn,$row["item_ID"]);
	$sub_array = array();
	$sub_array[] = $row["item_ID"];
	$sub_array[] =$row["ctgy_Name"];
	$sub_array[] = $row["item_Name"];
	$sub_array[] = $row["item_Price"];
	$sub_array[] = $available_stocks;
	$sub_array[] = get_stocks_status($available_stocks);
	$sub_array[] = '


<button class="btn btn-info view"  id="'.$row["item_ID"].'">View</button>
<button class="btn btn-primary edit"  id="'.$row["item_ID"].'">Edit</button>
<button class="btn btn-danger delete"  id="'.$row["item_ID"].'">Delete</button>
';
// <div class="btn-group">
//   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//     Action
//   </button>
//   <div class="dropdown-menu">
//     <a class="dropdown-item view"  id="'.$row["item_ID"].'">View</a>
//     <a class="dropdown-item edit"  id="'.$row["item_ID"].'">Edit</a>
//      <div class="dropdown-divider"></div>
//     <a class="dropdown-item delete" id="'.$row["item_ID"].'">Delete</a>
//   </div>
// </div>
	$data[] = $sub_array;
}
$q = "SELECT * products";
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn,$q),
	"data"				=>	$data
);
echo json_encode($output);

?>



        
