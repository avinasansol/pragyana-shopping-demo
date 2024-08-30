<?php
	session_start();
	$page="order-now.php";
	$UpdateCart="The order quantity has been updated without any change.";
	if((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin"))
	{
		header("Location: cart-details.php");
	}
	include("include/connect-database.php");
	mysql_select_db("shop");
	$error="";
	if(isset($_POST['ConfirmOrder'])  && ($_POST['ConfirmOrder']=="Confirm Order"))
	{
		$error="please provide your ";
		if((!isset($_POST['txtShippingFirstName']))||($_POST['txtShippingFirstName']=="")||($_POST['txtShippingFirstName']==null))
		{
			$error=$error."first name, ";
		}
		if((!isset($_POST['txtShippingLastName']))||($_POST['txtShippingLastName']=="")||($_POST['txtShippingLastName']==null))
		{
			$error=$error."last name, ";
		}
		if((!isset($_POST['txtShippingAddress']))||($_POST['txtShippingAddress']=="")||($_POST['txtShippingAddress']==null))
		{
			$error=$error."address, ";
		}
		if((!isset($_POST['txtShippingCity']))||($_POST['txtShippingCity']=="")||($_POST['txtShippingCity']==null))
		{
			$error=$error."city, ";
		}
		if((!isset($_POST['txtShippingState']))||($_POST['txtShippingState']=="")||($_POST['txtShippingState']==null))
		{
			$error=$error."province, ";
		}
		if((!isset($_POST['txtShippingCountry']))||($_POST['txtShippingCountry']=="")||($_POST['txtShippingCountry']==null))
		{
			$error=$error."country, ";
		}
		if((!isset($_POST['txtShippingPostalCode']))||($_POST['txtShippingPostalCode']=="")||($_POST['txtShippingPostalCode']==null))
		{
			$error=$error."postal code, ";
		}
		if((!isset($_POST['PaymentOption']))||($_POST['PaymentOption']=="")||($_POST['PaymentOption']==null))
		{
			$error=$error."payment option, ";
		}
		if($error!="please provide your ")
		{
			$error[(strlen($error)-2)]=".";
			if(isset($_POST['PayNow']) && isset($_POST['OrderID']) && ($_POST['PayNow']=="PAY NOW"))
			{
				$id=$_POST['OrderID'];
				$sql="SELECT * FROM `order` WHERE id='".$id."' AND `user`='".$_SESSION['LogdUsrDet'][1]."'";
				$result=mysql_query($sql);
				if($row=mysql_fetch_array($result))
				{
					$error="";
				}
				else
				{
					header("Location: index.php");
				}
			}
		}
		else
		{
			$error="";
			$id=3238;
			$sql="SELECT MAX(`id`) FROM `order`";
			$result=mysql_query($sql);
			if($row=mysql_fetch_array($result))
			{
				$id=(int)$row[0];
			}
			if($id==0)
			{
				$id=3238;
			}
			$id=$id+1;
			$price=0;
			$sql="SELECT `product`, `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."`";
			$result=mysql_query($sql);
			$i=0;
			while($row=mysql_fetch_array($result))
			{
				$i++;
				$sql="SELECT `price` FROM `shop`.`product` WHERE `id`='".$row['product']."' ";
				$res=mysql_query($sql);
				if($rw=mysql_fetch_array($res))
				{
					$price+=$rw['price']*$row['quantity'];
				}
				$sql="INSERT INTO `shop`.`order_".$_SESSION['LogdUsrDet'][1]."` (`order_id`, `product`, `quantity`, `price`) VALUES ('".$id."', '".$row['product']."', '".$row['quantity']."', '".$rw['price']."')";
				mysql_query($sql);
				$sql="DELETE FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$row['product']."'";
				mysql_query($sql);
				$sql="UPDATE `shop`.`product` SET `qty`=(`qty` - ".$row['quantity'].") WHERE `id`='".$row['product']."'";
				mysql_query($sql);
			}
			if($i==0)
			{
				$error="your cart is empty right now. please add some product to your cart and then come back again here.";
			}
			else
			{
				$sql="SELECT `zone` FROM `country` WHERE `iso2`='".$_POST['txtShippingCountry']."'";
				$row=mysql_fetch_array(mysql_query($sql));
				$sql="SELECT `shipping` FROM `shipping` WHERE `zone`='".$row['zone']."' AND ((`from`<'".$price."' AND `to`>'".$price."') OR (`to`='".$price."') OR (`from`='".$price."'))";
				$row=mysql_fetch_array(mysql_query($sql));
				$shipping=($row['shipping'] * $price /100);
				if($shipping==0)
				{ 
					$row=mysql_fetch_array(mysql_query("SELECT `value` FROM `settings` WHERE `function`='default_shipping'"));
					$shipping=($row['value'] * $price /100);
				}
				$price+= $shipping;
				$sql="INSERT INTO `shop`.`order` (`id`, `user`, `date`, `amount`, `payment_option`, `status`, `fname`, `lname`, `add`, `city`, `state`, `country`, `pin_code`) VALUES ('".$id."', '".$_SESSION['LogdUsrDet'][1]."', CURDATE(), '".$price."', '".$_POST['PaymentOption']."', '0', '".$_POST['txtShippingFirstName']."', '".$_POST['txtShippingLastName']."', '".$_POST['txtShippingAddress']."', '".$_POST['txtShippingCity']."', '".$_POST['txtShippingState']."', '".$_POST['txtShippingCountry']."', '".$_POST['txtShippingPostalCode']."')";
				mysql_query($sql);
			}
		}
	}
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Order Your Cart</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
<?php
	if($error!="" || !isset($_POST['ConfirmOrder']))
	{
?>
	<style>
	.label
	{
		text-align:right; font-size:11px; font-weight:bold; color:#666666;
	}
	.content
	{
		text-align:left;
	}
	.content input
	{
		border:#666666 solid 1px; border-radius:5px; background-color:#FFFFCC; padding-left:5px;
	}
	.content select
	{
		border:#666666 solid 1px; border-radius:5px; background-color:#FFFFCC; padding-left:5px;
	}
	</style>
	<?php
		$sql="SELECT  `username`, `name`, `last_name`, `add`, `pin_code`, `city`, `state`, `country`, `phno` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
		$result=mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
		}
	?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="frmCheckout" >
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader">
            <td colspan="2" style="font-size:12px; font-weight:bold; color:#666666; text-transform:uppercase;">Shipping Information</td>
        </tr>
        <tr>
            <td width="45%" class="label">First Name: </td>
            <td width="55%" class="content"><input name="txtShippingFirstName" type="text" value="<?php if(isset($_POST['txtShippingFirstName'])) echo $_POST['txtShippingFirstName']; else echo $row['name'];?>" class="box" id="txtShippingFirstName" size="30" maxlength="50" onclick="this.select()"></td>
        </tr>
        <tr>
            <td class="label">Last Name: </td>
            <td class="content"><input name="txtShippingLastName" type="text" class="box" value="<?php if(isset($_POST['txtShippingLastName'])) echo $_POST['txtShippingLastName']; else echo $row['last_name'];?>" id="txtShippingLastName" size="30" maxlength="50" onclick="this.select()"></td>
        </tr>
        <tr>
            <td class="label">Address: </td>
            <td class="content"><input name="txtShippingAddress" type="text" value="<?php if(isset($_POST['txtShippingAddress'])) echo $_POST['txtShippingAddress']; else echo $row['add'];?>" class="box" id="txtShippingAddress" size="50" maxlength="100" onclick="this.select()"></td>
        </tr>
        <tr>
            <td class="label">City: </td>
            <td class="content"><input name="txtShippingCity" type="text" value="<?php if(isset($_POST['txtShippingCity'])) echo $_POST['txtShippingCity']; else echo $row['city'];?>" class="box" id="txtShippingCity" size="30" maxlength="32" onclick="this.select()"></td>
        </tr>
        <tr>
            <td class="label">Province / State: </td>
            <td class="content"><input name="txtShippingState" type="text" value="<?php if(isset($_POST['txtShippingState'])) echo $_POST['txtShippingState']; else echo $row['state'];?>" class="box" id="txtShippingState" size="30" maxlength="32" onclick="this.select()"></td>
        </tr>
        <tr>
            <td class="label">Country: </td>
            <td class="content">
			<select name="txtShippingCountry" style="width:330px;" >
				<option value="<?php if(isset($_POST['txtShippingCountry'])) echo $_POST['txtShippingCountry']; else echo $row['country'];?>"><?php 
				if(isset($_POST['txtShippingCountry']))
					$country=$_POST['txtShippingCountry']; 
				else
					$country=$row['country']; 
				mysql_select_db("shop");
				$rslt=mysql_query("SELECT `short_name` FROM `country` WHERE `iso2`='".$country."'");
				if($row1=mysql_fetch_array($rslt))
				{echo $row1['short_name'];}
				?>
				<?php
				$rslt=mysql_query("SELECT `iso2`, `short_name` FROM `country`");
				while($row1=mysql_fetch_array($rslt))
				{
				?><option value="<?php echo $row1['iso2'];?>"><?php echo $row1['short_name'];?></option><?php
				}
				?>
			</select>
			</td>
        </tr>
        <tr>
            <td class="label">Postal / Zip Code: </td>
            <td class="content"><input name="txtShippingPostalCode" value="<?php if(isset($_POST['txtShippingPostalCode'])) echo $_POST['txtShippingPostalCode']; else echo $row['pin_code'];?>" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10" style="width:200px;" onclick="this.select()"></td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top:20px; color:#555555; font-size:12px; font-weight:bold; text-align:center;" class="label">SELECT PAYMENT METHOD</td>
		</tr>
		<tr>
            <td colspan="2" style="text-align:center;" class="content">
				<select name="PaymentOption" style="width:100px;">
					<?php if(isset($_POST['PaymentOption'])) echo "<option value='".$_POST['PaymentOption']."'>".$_POST['PaymentOption']."</option>"; ?>
					<option value="PayPal">PayPal</option>
				</select>
			</td>
        </tr>
        <tr>
            <td colspan="2" style="color:#FF0000; font-size:10px; text-align:center;">
			<?php if($error!="") echo $error;?>
			</td>
		</tr>
        <tr>
            <td colspan="2" style="color:#555555; font-size:12px; font-weight:bold; text-align:center;" class="label">
				<input type="submit" name="ConfirmOrder" value="Confirm Order" style="font-weight:bold; text-transform:uppercase; color:#990000; border:#666666 solid 1px; border-radius:15px; padding:10px 20px 10px 20px; background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;" />
			</td>
		</tr>
    </table>
    <p>&nbsp;</p>
</form> 
<?php
}
else
{
		$sql="SELECT * FROM `order` WHERE id='".$id."'";
		$result=mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
		}
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
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" class="standard-form">

	<?php
		$sql="SELECT  `username`, `name`, `last_name`, `add`, `pin_code`, `city`, `state`, `country`, `phno` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
		$result=mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
		}
	?>
			<input name="FirstName" type="hidden" value="<?php echo $row['name'];?>" >
			
			<input name="LastName" type="hidden" value="<?php echo $row['last_name'];?>" >
			
			<input name="Address" type="hidden" value="<?php echo $row['add'];?>">
			
			<input name="City" type="hidden" value="<?php echo $row['city'];?>">
			
			<input name="State" type="hidden" value="<?php echo $row['state'];?>">
			
			<input name="Country" type="hidden" value="<?php echo $row['country'];?>">
			
			<input name="PostalCode" type="hidden" value="<?php echo $row['pin_code'];?>">
	
						<?php
						$price=0;
						$sql="SELECT `product`, `quantity`, `price` FROM `order_".$_SESSION['LogdUsrDet'][1]."` WHERE `order_id`='".$id."'";
						$result1=mysql_query($sql);
						$i=0;
						$price=0;
						while($row1=mysql_fetch_array($result1))
						{
							$i++;
							$sql="SELECT `name` FROM `product` WHERE `id`='".$row1['product']."'";
							$result2=mysql_query($sql);
							$row2=mysql_fetch_array($result2);
							$price+=$row1['price'];
							?>
          					<input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo $row2['name'];?>" />
        					<input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $row1['quantity'];?>" />
        					<input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo $row1['price'];?>" />
							<?php
						}
						if($i!=0)
						{
							$row3=mysql_fetch_array(mysql_query("SELECT `amount` FROM `order` WHERE id='".$id."' AND `user`='".$_SESSION['LogdUsrDet'][1]."'"));
						?>
          					<input type="hidden" name="item_name_<?php echo ($i+1); ?>" value="shipping" />
        					<input type="hidden" name="quantity_<?php echo ($i+1); ?>" value="1" />
        					<input type="hidden" name="amount_<?php echo ($i+1); ?>" value="<?php echo ($row3['amount']-$price);?>" />
						<?php
						}
						?>
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="upload" value="1" />
							<input type="hidden" name="business" value="avin.asansol@gmail.com" />
							<input type="hidden" name="currency_code" value="INR" />
							<input type="hidden" name="lc" value="IN" />
							<input type="hidden" name="rm" value="2" />
							<input type="hidden" name="return" value="http://localhost/shop/thanks.php" />
							<input type="hidden" name="cancel_return" value="http://localhost/shop/orders.php" />
							<input type="hidden" name="notify_url" value="" /><br />
        					<input type="submit" class="submit-button" style="width:150px; height:52px; background:url(img/pay-now.gif) no-repeat; border:0; cursor:pointer;" value="" />  
   						</form>  
					    <p>&nbsp;</p>
						<table align="center" width="98%">
							<tr>
								<td width="50%" align="right">
								<img src="img/paypal.jpg" style="width:400px; height:330px; border:0;" />
								</td>
								<td width="50%" align="right">
								<img src="img/paying.jpg" style="width:400px; height:400px; border:0;" />
								</td>
							</tr>
						</table>
<?php
}
?>
	<br />
						</div>
						<div id="main-content-bottom">
						</div>
<?php
	include("include/bottom.php");
	if($error!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $error;?>");
	</script>
	<?php
	}
?>