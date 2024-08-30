<?php
	session_start();
	$page="members.php";
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
		$error="";
		include("../include/connect-database.php");
		mysql_select_db("shop");
		if(isset($_POST['ProQty']) && isset($_POST['OldQty']) && isset($_POST['UpdID']) )
		{
		if(isset($_POST['ProQty']) && isset($_POST['OldQty']) && isset($_POST['UpdID']) && isset($_POST['User']) && (((int)$_POST['OldQty']) > ((int)$_POST['ProQty'])))
		{
			$sql="UPDATE `product` SET `qty` = (`qty` + ".(((int)$_POST['OldQty']) - ((int)$_POST['ProQty'])).") WHERE `id`='".$_POST['UpdID']."' ";
			mysql_query($sql);
			if($_POST['ProQty']!="0")
			{
				$sql="UPDATE `cart_".$_POST['User']."` SET `quantity` = '".$_POST['ProQty']."' WHERE `cart_".$_POST['User']."`.`product` = '".$_POST['UpdID']."'";
				mysql_query($sql);
			}
			else
			{
				$sql="DELETE FROM `shop`.`cart_".$_POST['User']."` WHERE `cart_".$_POST['User']."`.`product`='".$_POST['UpdID']."'";
				mysql_query($sql);
			}
		}
		header("Location: members.php?email=".$_POST['User']);
		}
		include("admin-files/admin-top.php");
?>
		<h4>Members Viewer</h4>
<?php
if(isset($_REQUEST['email']))
{
	$sql="SELECT `name` , `last_name` ,  `gender`, `dob`, `org`, `add`, `pin_code`, `city`, `state`, `country`, `phno`, `date`, `last_login` FROM `user` WHERE `user`.`username` ='".$_REQUEST['email']."'";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
	{
	?>
	<table align="center">
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Member Name: </label>
		</td>
		<td align="left">
		<?php echo "".$row["name"]; ?> <?php echo "".$row["last_name"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Gender: </label>
		</td>
		<td align="left">
		<?php echo "".$row["gender"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Date of Birth: </label>
		</td>
		<td align="left">
		<?php echo "".$row["dob"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>E-Mail: </label>
		</td>
		<td align="left">
		<?php echo "".$_REQUEST['email']; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Company/Organization: </label>
		</td>
		<td align="left">
		<?php echo "".$row["org"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Street Address: </label>
		</td>
		<td align="left">
		<?php echo "".$row["add"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Postal Code: </label>
		</td>
		<td align="left">
		<?php echo "".$row["pin_code"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>City: </label>
		</td>
		<td align="left">
		<?php echo "".$row["city"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>State/Province: </label>
		</td>
		<td align="left">
		<?php echo "".$row["state"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Country: </label>
		</td>
		<td align="left">
		<?php
			$rslt=mysql_query("SELECT `long_name` FROM `country` WHERE `iso2`='".$row['country']."'");
			if($rw=mysql_fetch_array($rslt))
			{echo $rw['long_name'];}
			else{echo $row['country'];}?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Phone Number: </label>
		</td>
		<td align="left">
		<?php echo "".$row["phno"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Member Since: </label>
		</td>
		<td align="left">
		<?php echo "".$row["date"]; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<label style='font-size:11px; font-weight:bold; color:#666666;'>Last Login: </label>
		</td>
		<td align="left">
		<?php echo "".$row["last_login"]; ?>
		</td>
	</tr>
	</table>
	<?php
		$sql="SELECT `product`, `quantity`, `date` FROM `cart_".$_REQUEST['email']."`";
		$res=mysql_query($sql);
		$i=0;
		?>
		<br />
		<table align="center" cellpadding="5" cellspacing="5">
		<tr>
			<td colspan="3">
				<label style="color:#990000; font-weight:bold; min-height:300px; font-size:13px; text-decoration:underline;"><?php echo "".$row["name"]; ?>'s Cart</label>
			</td>
		</tr>
		<?php
		while($rw=mysql_fetch_array($res))
		{
			if($i==0)
			{
			?>
			<tr>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Product ID</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Quantity</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Added On</label>
				</td>
			</tr>
			<?php
				$i=1;
			}
			?>
			<tr>
				<td>
					<?php echo "".$rw["product"]; ?>
				</td>
				<td>
					<?php echo $rw['quantity'];?>
				</td>
				<td>
					<?php echo "".$rw["date"]; ?>
				</td>
			</tr>
			<?php
		}
		if($i==0)
		{
		?>
		<tr>
			<td colspan="3">
				Right now, there is no product in <?php echo "".$row["name"]; ?>'s Cart.
			</td>
		</tr>
		<?php
		}
		?>
		</table>
		<?php
		$sql="SELECT `id`, `date`, `amount` FROM `order` WHERE user='".$_REQUEST['email']."' AND `status`='0'";
		$res=mysql_query($sql);
		$i=0;
		?>
		<br />
		<table align="center" cellpadding="5" cellspacing="5">
		<tr>
			<td colspan="4">
				<label style="color:#990000; font-weight:bold; min-height:300px; font-size:13px; text-decoration:underline;">Orders of <?php echo "".$row["name"]; ?></label>
			</td>
		</tr>
		<?php
		while($rw=mysql_fetch_array($res))
		{
			if($i==0)
			{
			?>
			<tr>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Invoice ID</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Ordered Date</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Balance</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">View Details</label>
				</td>
			</tr>
			<?php
				$i=1;
			}
			?>
			<tr>
				<td>
					#<?php echo "".$rw["id"]; ?>
				</td>
				<td>
					<?php echo "".$rw["date"]; ?>
				</td>
				<td>
					Rs <?php echo "".$rw["amount"]; ?>
				</td>
				<td>
					<a style='text-decoration:none; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="order-bin.php?OrderID=<?php echo "".$rw["id"]; ?>">Details</a>
				</td>
			</tr>
			<?php
		}
		if($i==0)
		{
		?>
		<tr>
			<td colspan="3">
				Right now, there is no product in <?php echo "".$row["name"]; ?>'s Order List.
			</td>
		</tr>
		<?php
		}
		?>
		</table>
		<?php
		$sql="SELECT `id`, `date`, `amount` FROM `order` WHERE user='".$_REQUEST['email']."' AND `status`='1'";
		$res=mysql_query($sql);
		$i=0;
		?>
		<br />
		<table align="center" cellpadding="5" cellspacing="5">
		<tr>
			<td colspan="4">
				<label style="color:#990000; font-weight:bold; min-height:300px; font-size:13px; text-decoration:underline;">Products Delivered to <?php echo "".$row["name"]; ?></label>
			</td>
		</tr>
		<?php
		while($rw=mysql_fetch_array($res))
		{
			if($i==0)
			{
			?>
			<tr>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Invoice ID</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Ordered Date</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">Balance</label>
				</td>
				<td>
					<label style="color:#333333; font-weight:bold; font-size:13px; text-transform:uppercase;">View Details</label>
				</td>
			</tr>
			<?php
				$i=1;
			}
			?>
			<tr>
				<td>
					#<?php echo "".$rw["id"]; ?>
				</td>
				<td>
					<?php echo "".$rw["date"]; ?>
				</td>
				<td>
					Rs <?php echo "".$rw["amount"]; ?>
				</td>
				<td>
					<a style='text-decoration:none; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="delivery.php?OrderID=<?php echo "".$rw["id"]; ?>">Details</a>
				</td>
			</tr>
			<?php
		}
		if($i==0)
		{
		?>
		<tr>
			<td colspan="3">
				Right now, there is no product delivered to <?php echo "".$row["name"]; ?>.
			</td>
		</tr>
		<?php
		}
		?>
		</table>
		<?php
	}
	else
	{
		$error="invalid email id";
	}
}
if((!isset($_REQUEST['email']))||($error!=""))
{
	$sql="SELECT `name` , `last_name` ,  `username` , `country`, `last_login` FROM `user` ORDER BY `name`";
	$result=mysql_query($sql);
	?><hr />
	<table align="center" cellpadding="5" cellspacing="10" style="max-width:95%">
	<tr align="left" style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
		<td>
			Name
		</td>
		<td>
			Email ID
		</td>
		<td align="center">
			Country
		</td>
		<td align="center">
			Last Login
		</td>
		<td align="center">
			Details
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<hr />
		</td>
	</tr>
	<?php
	while($row=mysql_fetch_array($result))
	{
	?>
	<tr align="left">
		<td>
			<?php echo $row['name'];?> <?php echo $row['last_name'];?>
		</td>
		<td>
			<?php echo $row['username'];?>
		</td>
		<td align="center">
			<img src="admin-files/flags/<?php echo $row['country'];?>.png" style="max-width:22px; max-height:15px; border:0;" title="<?php 
			$rslt=mysql_query("SELECT `short_name` FROM `country` WHERE `iso2`='".$row['country']."'");
			if($rw=mysql_fetch_array($rslt))
			{echo $rw['short_name'];}
			else{echo $row['country'];}
			?>" />
		</td>
		<td align="center">
			<?php echo $row['last_login'];?>
		</td>
		<td align="center">
			<a style='text-decoration:none; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="members.php?email=<?php echo $row['username'];?>">Details</a>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<hr />
		</td>
	</tr>
	<?php
	}
?>
	</table>
<script type="text/javascript"> 
$(document).ready(function(){
    $("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
});
</script>
<?php
}
		include("admin-files/admin-bottom.php");
	}
?>