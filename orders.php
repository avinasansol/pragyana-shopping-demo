<?php
	session_start();
	$page="orders.php";
	$UpdateCart="The order quantity has been updated without any change.";
	if((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin"))
	{
		header("Location: cart-details.php");
	}
	include("include/connect-database.php");
	mysql_select_db("shop");
	include("include/top.php");
	if(isset($_REQUEST['id']))
	{
	?>
					<div id="main-content-top">
						<h4>Order Details</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
<?php
$id=$_REQUEST['id'];
$sql="SELECT * FROM `order` WHERE id='".$id."' AND `user`='".$_SESSION['LogdUsrDet'][1]."'";
$result=mysql_query($sql);
if($row=mysql_fetch_array($result))
{
	$sql="SELECT `name`, `last_name`, `add`, `pin_code`, `city`, `state`, `country` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
	$rslt=mysql_query($sql);
	if($rw=mysql_fetch_array($rslt))
	{
	}
?>
	<table cellpadding="2" cellspacing="2" align="center" style="text-align:left; max-width:95%">
		<tr>
			<td colspan="2">
				<strong>INVOICE #<?php echo $row['id'];?></strong><br />
				Invoice Date: <?php echo $row['date'];?><br /><hr /><br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong>INVOICE TO:</strong><br />
				<?php echo $rw['name'];?> <?php echo $rw['last_name'];?><br />
				<?php echo $rw['add'];?><br />
				<?php echo $rw['city'];?><br />
				<?php echo $rw['state'];?><br />
				<?php
				$sql="SELECT `long_name` FROM `country` WHERE `iso2`='".$rw['country']."'";
				$result1=mysql_query($sql);
				if($row1=mysql_fetch_array($result1))
				{
				}
				?>
				<?php echo $row1['long_name'];?><br />
				<?php echo $rw['pin_code'];?><br /><hr /><br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong>SHIPPING ADDRESS:</strong><br />
				<?php echo $row['fname'];?> <?php echo $row['lname'];?><br />
				<?php echo $row['add'];?><br />
				<?php echo $row['city'];?><br />
				<?php echo $row['state'];?><br />
				<?php
				$sql="SELECT `long_name` FROM `country` WHERE `iso2`='".$row['country']."'";
				$result1=mysql_query($sql);
				if($row1=mysql_fetch_array($result1))
				{
				}
				?>
				<?php echo $row1['long_name'];?><br />
				<?php echo $row['pin_code'];?><br /><hr /><br />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Description</strong>
			</td>
			<td>
				<strong>Price Per Unit</strong>
			</td>
		</tr>
		<?php
			$sql="SELECT `product`, `quantity`, `price` FROM `order_".$_SESSION['LogdUsrDet'][1]."` WHERE `order_id`='".$id."'";
			$result1=mysql_query($sql);
			$price=0;
			while($row1=mysql_fetch_array($result1))
			{
				$sql="SELECT `name` FROM `product` WHERE `id`='".$row1['product']."'";
				$result2=mysql_query($sql);
				$row2=mysql_fetch_array($result2);
				$price+=$row1['price'];
		?>
		<tr>
			<td>
				<?php echo $row2['name'];?> (Quantity: <?php echo $row1['quantity'];?>)
			</td>
			<td>
				Rs <?php echo $row1['price'];?>
			</td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td align="right">
				Shipping Charges: 
			</td>
			<td>
				Rs <?php echo ($row['amount']-$price);?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<strong>Total Price: </strong>
			</td>
			<td>
				<strong>Rs <?php echo $row['amount'];?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<hr />
			</td>
		</tr>
	</table><br /><br />
<?php
	if($row['status']==0)
	{
	?>
	<h4>Yet Unpaid?</h4>
	<label style="padding-top:20px; color:#555555; font-size:12px; font-weight:bold; text-align:center;">SELECT PAYMENT METHOD</label><br /><br />
	<form name="PayNow" method="post" action="order-now.php">
		<select name="PaymentOption" style="width:100px; border-radius:5px;">
			<option value="PayPal">PayPal</option>
		</select><br /><br />
		<input type="hidden" name="ConfirmOrder" value="Confirm Order" />
		<input type="hidden" name="OrderID" value="<?php echo $id;?>" />
		<input type="submit" name="PayNow" value="PAY NOW" style="font-weight:bold; text-transform:uppercase; color:#990000; border:#666666 solid 1px; border-radius:15px; padding:6px 20px 6px 20px; background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;" />
	</form><br /><br />
	<?php
	}
}
else
{
	echo "<font color='red'>There is no such order.</font>";
}
?>
					</div>
					<div id="main-content-bottom">
					</div>
	<?php
	}
	else
	{
?>
					<div id="main-content-top">
						<h4>Your Previous Orders</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
						<table align="center" cellpadding="5" cellspacing="5" style="max-width:850px;">
							<?php
								$sql="SELECT `id`, `date`, `amount`, `status` FROM `shop`.`order` WHERE user='".$_SESSION['LogdUsrDet'][1]."' ORDER BY `date`";
								$result=mysql_query($sql);
								$i=0;
								while($row=mysql_fetch_array($result))
								{
									$i++;
									if($i==1)
									{
									?>
									<tr align="center" style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
										<td>
											Serial No.
										</td>
										<td>
											Invoice ID
										</td>
										<td>
											Date
										</td>
										<td>
											Balance
										</td>
										<td>
											Status
										</td>
										<td>
											View Details
										</td>
									</tr>
									<?php
									}
									?>
									<tr align="center">
										<td>
											<strong><?php echo $i;?>)</strong>
										</td>
										<td>
											<strong><?php echo $row['id'];?></strong>
										</td>
										<td>
											<?php echo $row['date'];?>
										</td>
										<td>
											Rs <?php echo $row['amount'];?>
										</td>
										<td>
											<?php if($row['status']==1){?><img src="admin/admin-files/delivery.png" alt="Delivered" title="Delivered" style="max-height:48px; min-height:48px;" /><?php }else{?><img src="admin/admin-files/order-bin.png" alt="Not Yet Delivered" title="Not Yet Delivered" style="max-height:48px; min-height:48px;" /><?php }?>
										</td>
										<td>
											<a style='text-decoration:none; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="orders.php?id=<?php echo $row['id'];?>">Details</a>
										</td>
									</tr>
									<?php
								}
								?>
								</table>
								<?php
								if($i==0)
								{
									echo "<b style='color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-size:18px;'>Right now, there is no product in your order list.</b>";
								}
							?>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	}
	include("include/bottom.php");
?>