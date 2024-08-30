<?php
	session_start();
	$page="cart-details.php";
	if(isset($_SESSION['LogdUsrDet']))
	{
		if($_SESSION['LogdUsrDet'][0]=="GenUsr")
		{
			header("Location: cart.php");
		}
	}
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Your Shopping Cart</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
					<?php
					if(isset($_SESSION['YourCart']))
					{
						?>
						<table align="center">
							<tr>
								<td valign="middle" style="color:#990000; font-weight:bold; min-height:300px; font-size:13px;">
									Your shopping cart is not empty.<br />
									But you need to get logged in, to order your cart.<br /><br />
									If you already have an account,<br />
									please login using above login form.<br /><br />
									If you are a new user,<br />
									please <a href="signup.php" style="color:#444444;">click here</a> to sign up.
								</td>
								<td>
								<img src="img/full-cart.png" style="width:200px; height:230px; margin:15px; border:0;" />
								</td>
							</tr>
						</table>
						<?php
						$ProNoInCart=0;
						$CartProId['0']="";
						while($ProNoInCart<count($_SESSION['YourCart']))
						{
							$exists=0;
							for($i=0;$i<count($CartProId);$i++)
							{
								if($CartProId[$i]==$_SESSION['YourCart'][$ProNoInCart])
								{
									$exists=1;
									$CartProId[$i]=$_SESSION['YourCart'][$ProNoInCart];
									$cart[''.$_SESSION['YourCart'][$ProNoInCart].''][0]++;
									break;
								}
							}
							if($exists==0)
							{
								$CartProId[count($CartProId)]=$_SESSION['YourCart'][$ProNoInCart];
								$sql="SELECT `name`, `price` FROM `shop`.`product` WHERE `id`='".$_SESSION['YourCart'][$ProNoInCart]."' ";
								$res=mysql_query($sql);
								if($rw=mysql_fetch_array($res))
								{
									$cart[''.$_SESSION['YourCart'][$ProNoInCart].''][0]=1;
									$cart[''.$_SESSION['YourCart'][$ProNoInCart].''][1]=$rw['name'];
									$cart[''.$_SESSION['YourCart'][$ProNoInCart].''][2]=$rw['price'];
								}
							}
							$ProNoInCart++;
						}
						$price=0;
						?>
						<br /><br />
						<table align="center" cellpadding="5" cellspacing="5">
							<tr align="left" style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
								<td>
									Serail No.
								</td>
								<td>
									Product ID
								</td>
								<td>
									Order Quantity
								</td>
								<td>
									Product Name
								</td>
								<td>
									Price Per Unit (Rs.)
								</td>
							</tr>
						<?php
						for($i=1;$i<count($CartProId);$i++)
						{
							$price+=($cart[''.$CartProId[$i].''][0]*$cart[''.$CartProId[$i].''][2]);
							?>
							<tr align="left">
								<td align="center">
									<?php echo $i;?>) 
								</td>
								<td>
									<?php echo $CartProId[$i];?>
								</td>
								<td align="center">
									<?php echo $cart[''.$CartProId[$i].''][0];?>
								</td>
								<td>
									<?php echo $cart[''.$CartProId[$i].''][1];?>
								</td>
								<td align="center">
									<?php echo $cart[''.$CartProId[$i].''][2];?>
								</td>
							</tr>
							<?php
						}
						?>
						</table>
						<br /><u style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Total Price:</u> Rs. <?php echo $price;?><br /><br /><br />
						<?php
					}
					else
					{
						?>
						<table align="center">
							<tr>
								<td valign="middle" style="color:#990000; font-weight:bold; min-height:300px; font-size:13px;">
									Right now your shopping cart is empty.<br />
									Please add some product to your cart<br />
									and then come back again here.<br /><br />
									But, you need to get logged in, to order your cart.<br /><br />
									If you already have an account,<br />
									please login using above login form.<br /><br />
									If you are a new user,<br />
									please <a href="signup.php" style="color:#444444;">click here</a> to sign up.
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
?>