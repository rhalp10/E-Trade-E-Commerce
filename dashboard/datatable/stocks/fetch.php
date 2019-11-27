<?php
include('../db.php');
include('../function.php');
session_start();
$query = '';
$output = array();
$query .= "SELECT * ";
$query .= " FROM `item_stocks` `itms` 
LEFT JOIN `item_details` `itmd` ON `itmd`.`item_ID` = `itms`.`item_ID`
";
$query .= "WHERE `itmd`.`user_ID` = '".$_SESSION['login_id']."' AND";

if(isset($_POST["search"]["value"]))
{
 $query .= '(stock_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR item_Name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR item_Price LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR stock_Qnty LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR stock_Date LIKE "%'.$_POST["search"]["value"].'%" )';
}



if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY stock_ID ASC ';
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
	

	$sub_array = array();
	$sub_array[] = $row["stock_ID"];
	$sub_array[] = $row["item_Name"];
	$sub_array[] = $row["item_Price"];
	$sub_array[] = $row["stock_Qnty"];
	$sub_array[] = $row["stock_Date"];
	$sub_array[] = '

<button class="btn btn-primary view"  id="'.$row["stock_ID"].'">View</button>
<button class="btn btn-danger delete"  id="'.$row["stock_ID"].'">Delete</button>
';
// <div class="btn-group">
//   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//     Action
//   </button>
//   <div class="dropdown-menu">
//     <a class="dropdown-item view"  id="'.$row["stock_ID"].'">View</a>
  
//      <div class="dropdown-divider"></div>
//     <a class="dropdown-item delete" id="'.$row["stock_ID"].'">delete</a>
//   </div>
// </div>
  // <a class="dropdown-item edit"  id="'.$row["stock_ID"].'">Edit</a>
	$data[] = $sub_array;
}
$q = "SELECT * FROM `item_stocks` itms 
LEFT JOIN item_details itmd ON itmd.item_ID = itms.item_ID
WHERE itmd.user_ID = '".$_SESSION['login_id']."'";
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn,$q),
	"data"				=>	$data
);
echo json_encode($output);

?>



        
