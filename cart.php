<?php
	session_start();
	$page="cart.php";
	$UpdateCart="The order quantity has been updated without any change.";
	if((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin"))
	{
		header("Location: cart-details.php");
	}
	include("include/connect-database.php");
	mysql_select_db("shop");
	if(isset($_POST['RemID']) && isset($_POST['RemQty']))
	{
		$sql="DELETE FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product`='".$_POST['RemID']."'";
		mysql_query($sql);
	}
	if(isset($_POST['ProQty']) && isset($_POST['OldQty']) && isset($_POST['UpdID']) && (((int)$_POST['OldQty']) != ((int)$_POST['ProQty'])))
	{
		$sql="SELECT `qty` FROM `shop`.`product` WHERE `id`='".$_POST['UpdID']."' ";
		$result=mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
			if($row['qty']<=0)
			{
				$UpdateCart="The product is removed from your cart as it is no more available.";
				$sql="DELETE FROM `cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['UpdID']."'";
				mysql_query($sql);
			}
			else if($row['qty']<(((int)$_POST['ProQty'])))
			{
				$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$row['qty']."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['UpdID']."'";
				mysql_query($sql);
				$UpdateCart="The order quantity has been updated as the maximum available quantity of the product.";
			}
			else
			{
				$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$_POST['ProQty']."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['UpdID']."'";
				mysql_query($sql);
				$UpdateCart="The order quantity has been updated successfully.";
			}
		}
	}
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Your Shopping Cart</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
						<table align="center" cellpadding="5" cellspacing="5" width="850px;">
							<?php
								$price=0;
								$sql="SELECT `product`, `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."`";
								$result=mysql_query($sql);
								$i=0;
								while($row=mysql_fetch_array($result))
								{
									$i++;
									if($i==1)
									{
									?>
									<tr align="center" style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
										<td width="12%">
											Serial<br />No.
										</td>
										<td width="12%">
											Product<br />Image
										</td>
										<td width="12%">
											Product<br />ID
										</td>
										<td width="12%">
											Order<br />Quantity
										</td>
										<td width="16%">
											Product<br />Name
										</td>
										<td width="12%">
											Per Unit <br />Price(Rs.)
										</td>
										<td width="12%">
											Total <br />Price(Rs.)
										</td>
										<td width="12%">
											Remove
										</td>
									</tr>
									<?php
									}
									$sql="SELECT `name`, `price`, `qty`, `img` FROM `shop`.`product` WHERE `id`='".$row['product']."' ";
									$res=mysql_query($sql);
									if($rw=mysql_fetch_array($res))
									{
										$price+=$rw['price']*$row['quantity'];
									?>
									<tr align="center">
										<td>
											<?php echo $i;?>) 
										</td>
										<td>
											<img src="product-img/<?php if($rw['img']!=""){echo $rw['img'];}?>" alt="NO IMAGE" style="max-width:48px; max-height:48px;"   />
										</td>
										<td>
											<?php echo $row['product'];?>
										</td>
										<td>
											<form action="cart.php" method="post">
												<input type="hidden" name="UpdID" value="<?php echo $row['product'];?>" />
												<input type="hidden" name="OldQty" value="<?php echo $row['quantity'];?>" />
												<select name="ProQty">
												<option value="<?php echo $row['quantity'];?>"><?php echo $row['quantity'];?></option>
												<?php
												for($j=1;$j<=$rw['qty'];$j++)
												{
													if($j!=$row['quantity'])
													{
												?>
												
												<option value="<?php echo $j;?>"><?php echo $j;?></option>
												<?php
													}
												}
												?>
												</select>&nbsp;&nbsp;
												<input type="submit" title="Update The Quantity" value="" style="border:0; background-color:#FFFFFF; background-image:url(img/update.png); background-repeat:no-repeat; cursor:pointer;" />
											</form>
										</td>
										<td>
											<?php echo $rw['name'];?>
										</td>
										<td>
											<?php echo $rw['price'];?>
										</td>
										<td>
											<?php echo ($rw['price']*$row['quantity']);?>
										</td>
										<td>
											<form action="cart.php" method="post">
												<input type="hidden" name="RemID" value="<?php echo $row['product'];?>" />
												<input type="hidden" name="RemQty" value="<?php echo $row['quantity'];?>" />
												<input type="submit" title="Remove The Product From Your Cart" value="" style="border:0; background-color:#FFFFFF; background-image:url(img/remove.jpg); background-repeat:no-repeat; cursor:pointer;" />
											</form>
										</td>
									</tr>
									<?php
									}
								}
							?>
						</table>
						<?php
						if($i!=0)
						{
						?>
						<br /><u style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Total Price:</u> Rs. <?php echo $price;?><br />
						<?php 
							$sql="SELECT `zone` FROM `country` WHERE `iso2`=(SELECT `country` FROM `user` WHERE `username` = '".$_SESSION['LogdUsrDet'][1]."')";
							$row=mysql_fetch_array(mysql_query($sql));
							$sql="SELECT `shipping` FROM `shipping` WHERE `zone`='".$row['zone']."' AND ((`from`<'".$price."' AND `to`>'".$price."') OR (`to`='".$price."') OR (`from`='".$price."'))";
							$row=mysql_fetch_array(mysql_query($sql));
							$shipping=($row['shipping'] * $price /100);
							if($shipping==0)
							{ 
								$row=mysql_fetch_array(mysql_query("SELECT `value` FROM `settings` WHERE `function`='default_shipping'"));
								$shipping=($row['value'] * $price /100);
							}
						?>
						<br /><u style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Shipping Charge:</u> Rs. <?php echo $shipping;?><br />
						<br /><u style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Net Amount to be paid:</u> Rs. <?php echo ($price + $shipping);?><br /><br />
						<p style="color:#990000; font-weight:bold; font-size:13px;">
							Now, you need to enter the billing address and pay the money to order your cart.<br />
							Click order now button to enter the billing address and pay using PayPal.<br />
						</p>
						<table align="center" width="70%">
							<tr>
								<td align="left">
									<form action="index.php">
										<input type="image" src="img/continue-shopping.png" />
									</form>
								</td>
								<td align="right">
									<form action="order-now.php">
										<input type="image" src="img/order-now.png" />
									</form>
								</td>
							</tr>
						</table>
						<?php
						}
						if($i==0)
						{
						?>
						<table align="center">
							<tr>
								<td valign="middle" style="color:#990000; font-weight:bold; min-height:300px; font-size:13px;">
									Right now your shopping cart is empty.<br />
									Please add some product to your cart<br />
									and then come back again here.<br /><br />
								</td>
								<td>
								<img src="img/empty-cart.png" style="width:256px; height:256px; margin:15px; border:0;" />
								</td>
							</tr>
						</table>
						<?php
						}
						?>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
	if(isset($_POST['ProQty']) && isset($_POST['OldQty']) && isset($_POST['UpdID']))
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $UpdateCart;?>");
	</script>
	<?php
	}
?>