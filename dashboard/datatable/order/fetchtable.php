<?php 
include('../db.php');
session_start();
$or_ID = $_REQUEST['order_ID'];
$sql = "SELECT * FROM `order` `ord`
LEFT JOIN `user` `u` ON `ord`.`user_ID` = `u`.`user_ID` 
LEFT JOIN `order_status` `ors` ON `ord`.`ors_ID` = `ors`.`ors_ID`";

$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row)
{
$or_ID = $row['or_ID'];
$or_Date = $row['or_Date'];
$ors_Name = $row['ors_Name'];

}


$sql = "SELECT * FROM `order_item` `ordi`
LEFT JOIN `item_details` `itmd` ON `ordi`.`item_ID` = `itmd`.`item_ID`
where `ordi`.`or_ID`  = $or_ID ";

$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();



?>
<hr>
 <ul class="list-group">
    <li class="list-group-item active">Order #<?php echo $or_ID;?></li>
    <li class="list-group-item"><?php echo $ors_Name;?><br>
		Placed on Order #<?php echo $or_ID;?> <?php 
    	if ($_SESSION['login_level'] == 2) {
    		?>
    		<a class="btn btn-sm btn-info proceed float-right" href="order_print?order_ID=<?php echo $or_ID;?>" target="_BLANK">PRINT</a>
    		<?php
    	}
    	else{
    		?>
    		<a class="btn btn-sm btn-info proceed float-right" href="dashboard/order_print?order_ID=<?php echo $or_ID;?>" target="_BLANK">PRINT</a>
    		<?php
    	}
    	?></li>
	<li class="list-group-item ">
		<table class="table table-striped table-sm" >
			<thead>
				<th>#</th>
				<th>Item</th>
				<th>Price</th>
				<th>Quantity(KG)</th>
				<th>Subtotal</th>
				<th></th>
				 
			</thead>
			<tbody>
			</tbody>
			<?php 
			$Total = 0 ;
			foreach($result as $row)
			{
			$Subtotal = $row['ord_Price'] * $row['ord_Qnty'];
			?>
			<tr>
				<td><?php echo $row['ord_ID'];?></td>
				<td><?php echo $row['item_Name'];?></td>
				<td><?php echo '&#x20b1; '.$row['item_Price'];?></td>
				<td><?php echo $row['ord_Qnty'];?></td>
				<td><?php echo '&#x20b1; '.number_format($Subtotal,2);?></td>
				<td><a class="btn btn-primary chat"  href="chat?seller_id=<?php echo $row['user_ID'];?>" target="_BLANK">Chat Seller</a></td>

	
			
			</tr>
			<?php
			$Total += $Subtotal ;
			}
			?>
		</table>
	</li>
    <li class="list-group-item"><div class=" float-right">Total: <?php echo '&#x20b1; '.number_format($Total,2);?></div></li>

</ul>