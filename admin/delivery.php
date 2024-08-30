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
		include("admin-files/admin-top.php");
?>
	<h4>Delivery Viewer (Dispatched Products)</h4>
<?php
$error="";
if((isset($_REQUEST['OrderID'])))
{
	$id=$_REQUEST['OrderID'];
	$sql="SELECT * FROM `order` WHERE id='".$id."' AND `status`='1'";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
	{
		$sql="SELECT `name`, `last_name`, `add`, `pin_code`, `city`, `state`, `country` FROM `user` WHERE `username`='".$row['user']."'";
		$rslt=mysql_query($sql);
		if($rw=mysql_fetch_array($rslt))
		{
		}
	?><br />
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
					Postal Code: <?php echo $rw['pin_code'];?><br /><hr /><br />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<strong>INVOICE #<?php echo $row['id'];?></strong><br />
					Invoice Date: <?php echo $row['date'];?><br />
					Delivery Date: <?php echo $row['delivery_date'];?><br /><hr /><br />
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
			<tr>
				<td colspan="2">
					<strong>Payment Description:</strong><br />
					Gateway: <?php echo $row['gateway'];?><br />
					Transaction ID: <?php echo $row['transaction_id'];?><br /><hr /><br />
				</td>
			</tr>
		</table>
	</div><br /><br />
	<a href="javascript:void(printSpecial())" style="text-decoration:none; font-weight:bold; text-transform:uppercase; color:#990000; border:#666666 solid 1px; border-radius:15px; padding:10px 20px 10px 20px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;">
								PRINT THE ORDER
				</a><br /><br /><br />
	<?php
	}
	else
	{
		$error="There is no such order.";
	}
}
if((isset($_REQUEST['StartDate']))&&(isset($_REQUEST['EndDate']))&&(!isset($_REQUEST['OrderID'])))
{
	if((($_REQUEST['StartDate']=="")||($_REQUEST['StartDate']==null))&&(($_REQUEST['EndDate']=="")||($_REQUEST['EndDate']==null)))
	{
		$error="Please select the Start Date and End Date.";
	}
	else if((($_REQUEST['StartDate']=="")||($_REQUEST['StartDate']==null)))
	{
		$error="Please select the Start Date.";
	}
	else if((($_REQUEST['EndDate']=="")||($_REQUEST['EndDate']==null)))
	{
		$error="Please select the End Date.";
	}
	else
	{
		$StartDate=date('Y-m-d', strtotime($_REQUEST['StartDate']));
		$EndDate=date('Y-m-d', strtotime($_REQUEST['EndDate']));
		if(($StartDate=="1970-01-01")&&($EndDate=="1970-01-01"))
		{
			$error="Please enter a valid Start Date and End Date.";
		}
		else if($StartDate=="1970-01-01")
		{
			$error="Please enter a valid Start Date.";
		}
		else if($EndDate=="1970-01-01")
		{
			$error="Please enter a valid End Date.";
		}
		else if($error=="")
		{
		?>		<hr />
				<table align="center" cellpadding="5" cellspacing="5" style="max-width:850px;">
				<?php
				$sql="SELECT `id`, `date`, `amount`, `country` FROM `shop`.`order` WHERE `status`='1' AND `date` BETWEEN DATE_FORMAT('".$StartDate."','%Y-%m-%d') AND DATE_FORMAT('".$EndDate."','%Y-%m-%d') ORDER BY `date`";
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
							<?php echo $row['id'];?>
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
							<a style='text-decoration:none; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="delivery.php?OrderID=<?php echo $row['id'];?>">Details</a>
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
					$error="No Products where sold in that period.";
				}
?>
<script type="text/javascript"> 
$(document).ready(function(){
    $("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
});
</script>
<?php
		}
	}
}
if((((!isset($_REQUEST['StartDate']))||(!isset($_REQUEST['EndDate'])))&&(!isset($_REQUEST['OrderID'])))||($error!=""))
{
?>
<link rel="stylesheet" type="text/css" href="admin-files/datepicker.css" /> 
<script type="text/javascript" src="admin-files/datepicker.js"></script> 

<style>
  input {
    font-family:monospace;
  }
</style>
<label style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Select the dates between witch the placed orders you want to view:</label><br /><br />
<div style="width:320px; padding:0 250px 0 250px;">
  <form action="delivery.php" method="get">
  	<label style="color:#444444; font-weight:bold;">Start Date: </label>
    <input name="StartDate" id="start_dt" value="<?php if(isset($_REQUEST['StartDate'])){echo $_REQUEST['StartDate'];}?>" class='datepicker' size='11' title='DD-MM-YYYY' /> <br /> <br />
 	<label style="color:#444444; font-weight:bold;">&nbsp;&nbsp;&nbsp;End Date: </label>
    <input name="EndDate" id="end_dt" value="<?php if(isset($_REQUEST['EndDate'])){echo $_REQUEST['EndDate'];}?>" class='datepicker' size='11' title='DD-MM-YYYY' /> <br />
	<?php if($error!=""){echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."</label><br />";}?><br />
	<input type="submit" value="VIEW SOLD PRODUCTS" style='text-decoration:none; border:#666666 solid 1px; border-radius:10px; padding:5px 20px 5px 20px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; font-weight:bold; cursor:pointer;' />
  </form>
 </div>
<script type="text/javascript"> 
$(document).ready(function(){
    $("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
});
</script>
<?php
}
	include("admin-files/admin-bottom.php");
}
	if($error!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $error;?>");
	</script>
	<?php
	}
?>