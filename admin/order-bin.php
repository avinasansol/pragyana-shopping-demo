<?php
	session_start();
	$page="order-bin.php";
	if(!isset($_SESSION['LogdUsrDet']))
	{
		header("Location: ../");
	}
	else if($_SESSION['LogdUsrDet'][0]=="GenUsr")
	{
		header("Location: ../");
	}
	else if($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin")
	{
		include("../include/connect-database.php");
		mysql_select_db("shop");
		$Err="";
		if(isset($_POST['OrderID']) && isset($_POST['Gateway']) && isset($_POST['TransactionID']) && isset($_POST['Amount']))
		{
			$Err="please provide the ";
			if(($_POST['OrderID']=="")||($_POST['OrderID']==null))
			{
				$Err=$Err."order id, ";
			}
			if(($_POST['Gateway']=="")||($_POST['Gateway']==null))
			{
				$Err=$Err."gateway, ";
			}
			if(($_POST['TransactionID']=="")||($_POST['TransactionID']==null))
			{
				$Err=$Err."transaction id, ";
			}
			if(($_POST['Amount']=="")||($_POST['Amount']==null))
			{
				$Err=$Err."amount, ";
			}
			if($Err!="please provide the ")
			{
				$Err[(strlen($Err)-2)]=".";
			}
			else if(!preg_match('/^[0-9]{1,}$/', $_POST['Amount']))
			{
				$Err="please provide a valid amount.";
			}
			else
			{
				$sql="SELECT `status`, `amount` FROM `order` WHERE id='".$_POST['OrderID']."' AND `status`='0'";
				$result=mysql_query($sql);
				if($row=mysql_fetch_array($result))
				{
					if($row['status']==1)
					{
						$Err="invalid order.";
					}
					else if($row['amount']!=((int) $_POST['Amount']))
					{
						$Err="the amount doesn't match with the balance amount.";
					}
					else
					{
						$Err="";
						$sql="UPDATE `order` SET `status` = '1', `delivery_date` = CURDATE(), `gateway` = '".$_POST['Gateway']."', `transaction_id` = '".$_POST['TransactionID']."' WHERE id='".$_POST['OrderID']."'";
						mysql_query($sql);
						header("location: delivery.php?OrderID=".$_POST['OrderID']);
					}
				}
				else
				{
					$Err="invalid order.";
				}
			}
		}
		include("admin-files/admin-top.php");
?>
	<h4>Order Bin (Undelivered Orders Viewer)</h4>
	<?php
	$error="";
	if((isset($_REQUEST['OrderID'])))
	{
$id=$_REQUEST['OrderID'];
$sql="SELECT * FROM `order` WHERE id='".$id."' AND `status`='0'";
$result=mysql_query($sql);
if($row=mysql_fetch_array($result))
{
	$sql="SELECT `name`, `last_name`, `add`, `pin_code`, `city`, `state`, `country` FROM `user` WHERE `username`='".$row['user']."'";
	$rslt=mysql_query($sql);
	if($rw=mysql_fetch_array($rslt))
	{
	}
?><br /><br />
<div id="content">
	<table cellpadding="2" cellspacing="2" align="center" style="text-align:left; max-width:95%; background-color:#FFFFFF; padding:0 20px 0 20px;">
		<tr>
			<td colspan="2">
				<strong>INVOICE TO:</strong><br />
				<?php echo $rw['name'];?> <?php echo $rw['last_name'];?> (<a href="members.php?email=<?php echo $row['user'];?>">View Details</a>)<br />
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
				<strong>INVOICE #<?php echo $row['id'];?></strong><br />
				Invoice Date: <?php echo $row['date'];?><br /><hr /><br />
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
				Postal Code: <?php echo $row['pin_code'];?><br /><hr /><br />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Description</strong>
			</td>
			<td>
				<strong>Per Unit Price</strong>
			</td>
		</tr>
		<?php
			$sql="SELECT `product`, `quantity`, `price` FROM `order_".$row['user']."` WHERE `order_id`='".$id."'";
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
	</table>
</div>
<br /><br />
	<a href="javascript:void(printSpecial())" style="text-decoration:none; font-weight:bold; text-transform:uppercase; color:#990000; border:#666666 solid 1px; border-radius:15px; padding:10px 20px 10px 20px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;">
		PRINT THE ORDER
	</a><br /><br /><br />
	<p style="color:#990000; font-weight:bold; font-size:13px;">
		Have received the payment via <?php echo $row['payment_option'];?>?<br />
		Enter the payment Infromations:<br />
	</p>
		<form action="order-bin.php" method="post" onsubmit="return ValidateMarking()">
		<table cellpadding="4" cellspacing="4" align="center">
			<tr>
				<td align="right">
					<b>Gateway: </b>
				</td>
				<td align="left">
					<input type="text" name="Gateway" value="<?php if(isset($_POST['Gateway'])) echo $_POST['Gateway'];?>" />
				</td>
			</tr>
			<tr>
				<td align="right">
					<b>Transaction ID: </b>
				</td>
				<td align="left">
					<input type="text" name="TransactionID" value="<?php if(isset($_POST['TransactionID'])) echo $_POST['TransactionID'];?>" />
				</td>
			</tr>
			<tr>
				<td align="right">
					<b>Amount: </b>
				</td>
				<td align="left">
					<input type="text" name="Amount" value="<?php if(isset($_POST['Amount'])) echo $_POST['Amount'];?>" />
				</td>
			</tr>
			<?php if($Err!=""){?>
			<tr>
				<td colspan="2" align="center" style="color:#FF0000; font-size:11px;">
					<?php echo $Err;?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="2" align="center">
					<input type="hidden" name="OrderID" value="<?php echo $id?>" />
					<input type="submit" value="MARK AS DELIVERED" style="text-decoration:none; font-weight:bold; text-transform:uppercase; color:#990000; border:#666666 solid 1px; border-radius:15px; padding:8px 20px 8px 20px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;" />
				</td>
			</tr>
		</table>
		</form>
	<br /><br />
<?php
}
else
{
	echo "<font color='red'>There is no such order.</font>";
}
	}
	if((!isset($_REQUEST['OrderID']))||($error!=""))
	{
	?><hr />
								<table align="center" cellpadding="5" cellspacing="5" style="max-width:850px;">
								<?php
								$sql="SELECT `id`, `date`, `amount`, `country` FROM `shop`.`order` WHERE `status`='0' ORDER BY `date`";
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
											Order Date
										</td>
										<td>
											Balance
										</td>
										<td>
											Country
										</td>
										<td>
											View Details
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<hr />
										</td>
									</tr>
									<?php
									}
									?>
									<tr align="center">
										<td>
											<?php echo $i;?>)
										</td>
										<td>
											#<?php echo $row['id'];?>
										</td>
										<td>
											<?php echo $row['date'];?>
										</td>
										<td>
											Rs <?php echo $row['amount'];?>
										</td>
										<td>
											<?php
											$sql="SELECT `short_name` FROM `country` WHERE `iso2`='".$row['country']."'";
											$result1=mysql_query($sql);
											if($row1=mysql_fetch_array($result1))
											{
											}
											?>
											<img src="admin-files/flags/<?php echo $row['country'];?>.png" alt="<?php echo $row1['short_name'];?>" title="<?php echo $row1['short_name'];?>" />
										</td>
										<td>
											<a style='text-decoration:none; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="order-bin.php?OrderID=<?php echo $row['id'];?>">Details</a>
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<hr />
										</td>
									</tr>
									<?php
								}
								?>
								</table>
								<?php
								if($i==0)
								{
									echo "<b style='color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-size:18px;'>Right now, there is no product in order list.</b>";
								}
								?>
	<script type="text/javascript"> 
		$(document).ready(function(){
  		$("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
		});
	</script>
	<?php
	}
	include("admin-files/admin-bottom.php");
}
	if($Err!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $Err;?>");
	</script>
	<?php
	}
?>