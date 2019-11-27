<?php 
include('dbconfig.php');
session_start();

if (isset($_SESSION["login_user"])) {
	
	$login_id = $_SESSION["login_id"];
	 $query = mysqli_query($conn,"SELECT * FROM `order` WHERE user_ID = $login_id  AND ors_ID = 0");
	if (mysqli_num_rows($query) > 0) 
	{
		$rows = mysqli_fetch_assoc($query);
		$or_ID = $rows["or_ID"];

		$sql = "SELECT * FROM `order_item` `ordi`
				LEFT JOIN `item_details` `itmd` ON `ordi`.`item_ID` = `itmd`.`item_ID`
				where `ordi`.`or_ID`  = $or_ID ";
		$items = mysqli_query($conn,$sql);
		?>
		<ul class="list-group">
		    <li class="list-group-item active">Order #<?php echo $or_ID;?></li>
		 
			<li class="list-group-item ">
				<table class="table table-striped table-sm" >
					<thead>
						<th>#</th>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity(KG)</th>
						<th>Subtotal</th>
						<th class="text-center">Action</th>
					</thead>
					<tbody>
					</tbody>
					<?php 
					$Total = 0 ;
					while($row = mysqli_fetch_assoc($items))
					{
					$Subtotal = $row['ord_Qnty'] * $row['ord_Price'];
					?>
					<tr>
						<td><?php echo $row['ord_ID'];?></td>
						<td><?php echo $row['item_Name'];?></td>
						<td><?php echo '&#x20b1; '.$row['ord_Price'];?></td>
						<td><?php echo $row['ord_Qnty'];?></td>
						<td><?php echo '&#x20b1; '.number_format($Subtotal,2);?></td>
						<td class="text-center remove_item"  data-id="<?php echo $row['ord_ID'];?>">x</td>
					</tr>
					<?php
					$Total += $Subtotal ;
					}
					?>
				</table>
			</li>
		    <li class="list-group-item"><div class=" float-right">Total: <?php echo '&#x20b1; '.number_format($Total,2);?></div></li>
		    <input type="hidden" name="or_ID" id="or_ID" value="<?php echo $or_ID;?>">
		</ul>
		<?php
	}
	else{
		echo "NO ORDER CONTENT";
	}


	
}

	
?>