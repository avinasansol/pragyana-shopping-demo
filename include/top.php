<?php
	include("connect-database.php");
	$ShownLimit=0;
	$LogErr="";
	$AddToCart="";
	if(isset($_POST['Operation']))
	{
		if($_POST['Operation']=="EmptyTheCart")
		{
			if((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin"))
			{
				unset($_SESSION['YourCart']);
				unset($_SESSION['YourCartPrice']);
			}
			else if($_SESSION['LogdUsrDet'][0]=="GenUsr")
			{
				header("Location: cart-detail.php");
			}
			if(isset($_POST['op']))
			{
				$op=$_POST['op'];
			}
			if(isset($_POST['ShownLimit']))
			{
				$ShownLimit=(int) $_POST['ShownLimit'];
			}
		}
		else if($_POST['Operation']=="AddToCart")
		{
			if(isset($_POST['op']))
			{
				$op=$_POST['op'];
			}
			if(isset($_POST['ShownLimit']))
			{
				$ShownLimit=(int) $_POST['ShownLimit'];
			}
			if(isset($_POST['ProductID']))
			{
				if((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin"))
				{
					$qty=1;
					$qtyForPrice=1;
					if(isset($_POST['OrdrQty']))
					{
						$qty= (int) $_POST['OrdrQty'];
						$qtyForPrice= (int) $_POST['OrdrQty'];
					}
					if(!isset($_SESSION['YourCart']))
					{
						$_SESSION['YourCart'][0]=$_POST['ProductID'];
						$qty--;
					}
					for($i=1;$i<=$qty;$i++)
					{
						$_SESSION['YourCart'][count($_SESSION['YourCart'])]=$_POST['ProductID'];
					}
					mysql_select_db("shop");
					$sql="SELECT price FROM product WHERE id='".$_POST['ProductID']."'";
					$result=mysql_query($sql);
					$price=0;
					if($row=mysql_fetch_array($result))
					{
						$price=(int)$row['price'];
					}
					if(!isset($_SESSION['YourCartPrice']))
					{
						$_SESSION['YourCartPrice']=$price*$qtyForPrice;
					}
					else
					{
						$_SESSION['YourCartPrice']=((int)$_SESSION['YourCartPrice'])+($price*$qtyForPrice);
					}
				}
				else if($_SESSION['LogdUsrDet'][0]=="GenUsr")
				{
					$qty=1;
					if(isset($_POST['OrdrQty']))
					{
						$qty= (int) $_POST['OrdrQty'];
					}
					mysql_select_db("shop");
					$sql="SELECT `qty` FROM `shop`.`product` WHERE `id`='".$_POST['ProductID']."' ";
					$result=mysql_query($sql);
					if($row=mysql_fetch_array($result))
					{
						if($row['qty']<=0)
						{
							$AddToCart="The product is no more available.";
							$sql="SELECT `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$_POST['ProductID']."' ";
							$result1=mysql_query($sql);
							if($row1=mysql_fetch_array($result1))
							{
								$sql="DELETE FROM `cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['ProductID']."'";
								mysql_query($sql);
								$AddToCart=$AddToCart." Therefore it has been removed from your cart";
							}
						}
						else if($row['qty']<$qty)
						{
							$qty=$row['qty'];
							$sql="SELECT `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$_POST['ProductID']."' ";
							$result1=mysql_query($sql);
							if($row1=mysql_fetch_array($result1))
							{
								$qty-=$row1['quantity'];
								$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$row['qty']."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['ProductID']."'";
								mysql_query($sql);
							}
							else
							{
								$sql="INSERT INTO `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` (`product`, `quantity`, `date`) VALUES ('".$_POST['ProductID']."', '".$row['qty']."', CURDATE())";
								mysql_query($sql);
							}
							if($qty<0)
							{
								$AddToCart="The available quantity of the product is now ".$row['qty'].". Therefore ".(-1*$qty)." no. of the product has been removed from your cart.";
							}
							else
							{
								$AddToCart="The available quantity of the product is now ".$qty.". Therefore only ".$qty." no. of the product could be added.";
							}
						}
						else
						{
							$sql="SELECT `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$_POST['ProductID']."' ";
							$result1=mysql_query($sql);
							if($row1=mysql_fetch_array($result1))
							{
								$qty+=$row1['quantity'];
								if($row['qty']<$qty)
								{
									if(($row['qty']-$row1['quantity'])==0)
									{
										$AddToCart="The maximum available quantity of the product is already added to your cart.";
									}
									else
									{
										$AddToCart="The available quantity of the product is now ".($row['qty']-$row1['quantity']).". Therefore only ".($row['qty']-$row1['quantity'])." no. of the product could be added.";
										$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$row['qty']."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['ProductID']."'";
										mysql_query($sql);
									}
								}
								else
								{
									$AddToCart=($qty-$row1['quantity'])." no. of the product has been successfully added.";
									$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$qty."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['ProductID']."'";
									mysql_query($sql);
								}
							}
							else
							{
								$AddToCart=$qty." no. of the product has been successfully added.";
								$sql="INSERT INTO `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` (`product`, `quantity`, `date`) VALUES ('".$_POST['ProductID']."', '".$qty."', CURDATE())";
								mysql_query($sql);
							}
						}
					}
				}
			}
		}
		else if($_POST['Operation']=="UserLogIn")
		{
			if(isset($_POST['op']))
			{
				$op=$_POST['op'];
			}
			if(isset($_POST['ShownLimit']))
			{
				$ShownLimit=(int) $_POST['ShownLimit'];
			}
			if((!isset($_POST['txtUsrNme']))&&(!isset($_POST['txtPswd'])))
			{
				$LogErr="please enter your email id and password";
			}
			else if(!isset($_POST['txtUsrNme']))
			{
				$LogErr="please enter your email id";
			}
			else if(!isset($_POST['txtPswd']))
			{
				$LogErr="please enter your password";
			}
			else if((($_POST['txtUsrNme']=="")||($_POST['txtUsrNme']==null))&&(($_POST['txtPswd']=="")||($_POST['txtPswd']==null)))
			{
				$LogErr="please enter your email id and password";
			}
			else if(($_POST['txtUsrNme']=="")||($_POST['txtUsrNme']==null))
			{
				$LogErr="please enter your email id";
			}
			else if(($_POST['txtPswd']=="")||($_POST['txtPswd']==null))
			{
				$LogErr="please enter your password";
			}
			else if(!(preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/', $_POST['txtUsrNme'])))
			{
				$LogErr="email id or password doesn't match";
			}
			else if(preg_match('/[\'\"]/', $_POST['txtPswd']))
			{
				$LogErr="email id or password doesn't match";
			}
			else
			{
				mysql_select_db("shop");
				$sql="SELECT `username` FROM `user` WHERE `username`='".$_POST['txtUsrNme']."' && `password`='".$_POST['txtPswd']."'";
				$result=mysql_query($sql);
				if($row=mysql_fetch_array($result))
				{
					$_SESSION['LogdUsrDet'][0]="GenUsr";
					$_SESSION['LogdUsrDet'][1]=$_POST['txtUsrNme'];
					mysql_query("UPDATE `shop`.`user` SET `last_login`=CURDATE() WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'");
					if(isset($_SESSION['YourCart']))
					{
						mysql_select_db("shop");
						$ProNoInCart=0;
						while($ProNoInCart<count($_SESSION['YourCart']))
						{
							$qty=1;
							$sql="SELECT `qty` FROM `shop`.`product` WHERE `id`='".$_SESSION['YourCart'][$ProNoInCart]."' ";
							$result=mysql_query($sql);
							if($row=mysql_fetch_array($result))
							{
								if($row['qty']<=0)
								{
									$AddToCart="Some products have been removed from your cart as their availability has been changed.";
									$sql="SELECT `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$_POST['ProductID']."' ";
									$result1=mysql_query($sql);
									if($row1=mysql_fetch_array($result1))
									{
										$sql="DELETE FROM `cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_POST['ProductID']."'";
										mysql_query($sql);
									}
								}
								else
								{
									$sql="SELECT `quantity` FROM `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$_SESSION['YourCart'][$ProNoInCart]."' ";
									$res=mysql_query($sql);
									if($rw=mysql_fetch_array($res))
									{
										$qty+=$rw['quantity'];
										if($qty<$row['qty'])
										{
											$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$qty."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_SESSION['YourCart'][$ProNoInCart]."'";
											mysql_query($sql);
										}
										else
										{
											$AddToCart="Some products have been removed from your cart as their availability has been changed.";
											$sql="UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity` = '".$row['qty']."' WHERE `cart_".$_SESSION['LogdUsrDet'][1]."`.`product` = '".$_SESSION['YourCart'][$ProNoInCart]."'";
											mysql_query($sql);
										}
									}
									else
									{
										$sql="INSERT INTO `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` (`product`, `quantity`, `date`) VALUES ('".$_SESSION['YourCart'][$ProNoInCart]."', '1', CURDATE())";
										mysql_query($sql);
									}
								}
							}
							$ProNoInCart++;
						}
						unset($_SESSION['YourCart']);
						unset($_SESSION['YourCartPrice']);
					}
					if($page=="cart-details.php")
					{
						header("Location: cart.php");
					}
				}
				else
				{
					$sql="SELECT `username` FROM `admin` WHERE `username`='".$_POST['txtUsrNme']."' && `password`='".$_POST['txtPswd']."'";
					$result=mysql_query($sql);
					if($row=mysql_fetch_array($result))
					{
						$_SESSION['LogdUsrDet'][0]="ContrlrAdmin";
						$_SESSION['LogdUsrDet'][1]=$_POST['txtUsrNme'];
						header("Location: admin/control.php");
					}
					else
					{
						$LogErr="email id or password doesn't match";
					}
				}
			}
		}
		else if($_POST['Operation']=="ViewDetails")
		{
			$op="ViewDetails";
		}
		else if($_POST['Operation']=="SearchProduct")
		{
			$op="SearchProduct";
		}
		else if((($_POST['Operation']=="GoNext")||($_POST['Operation']=="GoPrev")))
		{
			if(isset($_POST['ProSearch']))
			{
				$op="SearchProduct";
			}
			if(isset($_POST['ShownLimit']))
			{
				$ShownLimit=(int) $_POST['ShownLimit'];
			}
		}
		else if($page=="product.php")
		{
			header("Location: index.php");
		}
	}
	if(isset($_SESSION['LogdUsrDet']))
	{
	if($_SESSION['LogdUsrDet'][0]=="GenUsr")
	{
		mysql_select_db("shop");
		$result=mysql_query("SELECT `product`, `quantity` FROM `cart_".$_SESSION['LogdUsrDet'][1]."`");
		while($row=mysql_fetch_array($result))
		{
			$res1=mysql_query("SELECT `qty` FROM `product` WHERE `id`='".$row['product']."'");
			if($rw1=mysql_fetch_array($res1))
			{
				if($rw1['qty'] == 0)
				{
					mysql_query("DELETE FROM `cart_".$_SESSION['LogdUsrDet'][1]."` WHERE `product`='".$row['product']."'");
					$AddToCart="Some products have been removed from your cart as their availability has been changed.";
				}
				if($rw1['qty'] < $row['quantity'])
				{
					mysql_query("UPDATE `cart_".$_SESSION['LogdUsrDet'][1]."` SET `quantity`='".$rw1['qty']."' WHERE `product`='".$row['product']."'");
					$AddToCart="Some products have been removed from your cart as their availability has been changed.";
				}
			}
		}
	}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/home.css" />
<link rel="shortcut icon" href="img/icon.png">
<title>Online Shopping</title>
<?php
if($page=="order-now.php")
{
	?>
<script type="text/javascript" src="admin/admin-files/jquery.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
$("h3").click(function(){
    $(this).parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").toggle("slow");
  });
});
</script>
	<?php
}
?>
<script type="text/javascript">
	function ValidateCartDetails()
    {
		var CurntCart=document.forms["EmptyTheCart"]["CurntCart"].value;
		if(CurntCart=="0")
		{
			alert("Your cart is empty right now.");
			return false;
		}
		return true;
	}
	function ValidateEmptyTheCart()
    {
		var CurntCart=document.forms["EmptyTheCart"]["CurntCart"].value;
		if(CurntCart=="0")
		{
			alert("Your cart is already empty.");
			return false;
		}
		else if (confirm("Are you sure, you want to empty the cart?")) 
       	{
			return true; 
		}
		else 
		{
			return false;
		}
		return true;
	}
	function ValidateSearchProduct()
    {
		var ProSearch=document.forms["SearchProduct"]["ProSearch"].value;
		if((ProSearch=="")||(ProSearch==null)||(ProSearch=="search for our products here"))
		{
			alert("Please enter some word to search.");
			return false;
		}
		return true;
	}
	function ValidateUserLogIn()
    {
		var txtUsrNme=document.forms["UserLogIn"]["txtUsrNme"].value;
		var txtPswd=document.forms["UserLogIn"]["txtPswd"].value;
		if((txtUsrNme=="" || txtUsrNme==null) && (txtPswd=="" || txtPswd==null))
		{
			document.getElementById("LogErr").innerHTML = "please enter your email id and password";
			alert("please enter your email id and password");
			return false;
		}
		if(txtUsrNme=="" || txtUsrNme==null)
		{
       		document.getElementById("LogErr").innerHTML = "please enter your email id";
			alert("please enter your email id");
			return false;
		}
		if(txtPswd=="" || txtPswd==null)
		{
       		document.getElementById("LogErr").innerHTML = "please enter your password";
			alert("please enter your password");
			return false;
		}
		return true;
	}
</script>
</head>

<body>
	<div id="wraper">
		<div id="head">
			<div id="head-left">
				<div id="head-left-top">
					<h1><a href="about-us.php">&nbsp;&nbsp;PRAGYANA<br />&nbsp;&nbsp;&nbsp;Shopping Demo</a></h1>
				</div>
				<div id="head-left-bottom">
					<div id="slogan">
						Have the whole world in<br />your bed room...!!!!
					</div>
					<div id="slogan-detail">
						Enjoy shopping with us 24*7<br />
					</div>
				</div>
			</div>
			<div id="head-right">
			</div>
		</div>
	</div>
	<div id="menu">
	<div class="red">
		<div id="slatenav">
			<ul>
				<li><a href="index.php" title="Home"<?php if($page=="index.php"){?> class="current"<?php }?>>Home</a></li>
				<li><a href="how-to-order.php" title="How to Order">How to Order</a></li>
				<li><a href="shipping-charges.php" title="Shipping Charges">Shipping Charges</a></li>
				<li><a href="about-us.php" title="About Us">About Us</a></li>
				<li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>
			</ul>
		</div>
	</div>
	</div>
	<div id="wraper">
		<div id="body-content">
			<div id="upper-content">
				<div id="box1">
					<h4>Your Shopping Cart</h4>
					<div style="height:100px; background-image:url(img/shoppin-cart.png); background-repeat:no-repeat; background-position:15px 0px;">
						<p style="font-size:11px; font-weight:bold; color:#666666; text-align:right; width:260px;">
							<br />
									Total Items: <label style="font-weight:normal; color:#000000; font-size:12px;">
									<?php  
										if((isset($_SESSION['LogdUsrDet']))&&($_SESSION['LogdUsrDet'][0]=="GenUsr"))
										{
											mysql_select_db("shop");
											$sql="SELECT `quantity` FROM `cart_".$_SESSION['LogdUsrDet'][1]."`";
											$result=mysql_query($sql);
											$CartCount=0;
											while($row=mysql_fetch_array($result))
											{
												$CartCount+=$row[0];
											}
											echo $CartCount;
										}
										else if(!isset($_SESSION['YourCart'])){echo "0";} else{ echo count($_SESSION['YourCart']);}
									?>
									</label><br />
									Total Price: <label style="font-weight:normal; color:#000000; font-size:12px;">Rs 
									<?php  
										if((isset($_SESSION['LogdUsrDet']))&&($_SESSION['LogdUsrDet'][0]=="GenUsr"))
										{
											mysql_select_db("shop");
											$sql="SELECT `product`,`quantity` FROM `cart_".$_SESSION['LogdUsrDet'][1]."`";
											$result=mysql_query($sql);
											$CartPrice=0;
											while($row=mysql_fetch_array($result))
											{
												$res=mysql_query("SELECT `price` FROM `product` WHERE `id`='".$row['product']."'");
												if($rw=mysql_fetch_array($res))
												{
													$CartPrice+=((int) $rw['price'])*$row['quantity'];
												}
											}
											echo $CartPrice;
										}
										else if(!isset($_SESSION['YourCartPrice'])){echo "0";} else{ echo $_SESSION['YourCartPrice'];}
									?>
									</label><br />
						</p>
								<?php
									if((isset($_SESSION['LogdUsrDet']))&&($_SESSION['LogdUsrDet'][0]=="GenUsr"))
									{
										?>
										<a style="border:#666666 solid 1px; border-radius:3px; width:100px; height:20px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; float:right; margin-right:20px; text-align:center; text-decoration:none; font-style:normal; padding-top:5px; font-weight:normal;" href="cart.php">View Deatils</a>
										<?php
									}
									else
									{
									?>
									<form name="EmptyTheCart" method="post" action="<?php echo $page;?>" onsubmit="return Validate<?php if((isset($_SESSION['LogdUsrDet']))&&($_SESSION['LogdUsrDet'][0]=="GenUsr")){echo "CartDetails";}else{echo "EmptyTheCart";}?>()">
										<input type="hidden" name="Operation" value="EmptyTheCart" />
										<input type="hidden" name="CurntCart" value="<?php if((isset($_SESSION['LogdUsrDet']))&&($_SESSION['LogdUsrDet'][0]=="GenUsr")){echo $CartCount;}else if(!isset($_SESSION['YourCart'])){echo "0";} else{ echo count($_SESSION['YourCart']);}?>" />
										<input type="hidden" name="ShownLimit" value="<?php echo $ShownLimit;?>" />
										<?php
										if($page=="product.php")
										{
										?>
										<input type="hidden" name="op" value="<?php echo $op;?>" />
										<?php
											if(isset($_POST['ProductID']))
											{
											?>
												<input type="hidden" name="ProductID" value="<?php echo $_POST['ProductID'];?>" />
											<?php
											}
											if(isset($_POST['ProSearch']))
											{
											?>
												<input type="hidden" name="ProSearch" value="<?php echo $_POST['ProSearch'];?>" />
											<?php
											}
											if(isset($_POST['ProCat']))
											{
											?>
												<input type="hidden" name="ProCat" value="<?php echo $_POST['ProCat'];?>" />
											<?php
											}
										}
										?>
										<input type="submit" value="empty the cart" style="border:#666666 solid 1px; border-radius:3px; width:100px; height:25px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; float:right; margin-right:20px;" />
									</form>
									<?php
									}
									?>
					</div>
					<?php
					if(((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]!="GenUsr")))
					{
					?>
					<a href="cart-details.php" onclick="return ValidateCartDetails()">click here to view details or order</a>
					<?php
					}
					else
					{
					?>
					<a href="orders.php">click here to view your orders</a>
					<?php
					}
					?>
				</div>
				<div id="box2">
					<h4>Product Search</h4>
					<div style="height:100px;text-align:center;">
						<form name="SearchProduct" method="post" action="product.php" onsubmit="return ValidateSearchProduct()">
						<input type="hidden" name="Operation" value="SearchProduct" />
						<table cellpadding="2" style="font-size:11px; font-weight:bold; color:#666666;" align="center">
							<tr>
								<td align="center">
						Search for: 
						<select name="ProCat" style="border:#666666 solid 1px; border-radius:3px; height:22px; padding-left:5px;" >
								<?php
								if(isset($_POST['ProCat'])&&($_POST['ProCat']!="All"))
								{
								?>
									<option value="<?php echo $_POST['ProCat'];?>"><?php echo $_POST['ProCat'];?></option>
								<?php
								}
								?>
								<option value="All">all catagories</option>
								<?php
								mysql_select_db("shop");
								$sql="SELECT `catagory` FROM `product` Group by `catagory`";
								$result=mysql_query($sql);
								while($row=mysql_fetch_array($result))
								{
									?>
									<option value="<?php echo $row['catagory'];?>"><?php echo $row['catagory'];?></option>
									<?php
								}
							?>
						</select>
								</td>
							</tr>
							<tr>
								<td align="center">
						<input type="text" name="ProSearch" value="<?php if(isset($_POST['ProSearch']) && ($_POST['ProSearch']!="")){echo $_POST['ProSearch'];} else{?>search for our products here<?php }?>" style="border:#666666 solid 1px; border-radius:3px; width:200px; height:16px; text-align:center;" onfocus="if(this.value=='search for our products here'){this.value='';}" onblur="if(this.value==''){this.value='search for our products here';}"  />
								</td>
							</tr>
							<tr>
								<td align="center">
						<input type="submit" value="search" style="border:#666666 solid 1px; border-radius:3px; width:60px; height:25px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;" />
								</td>
							</tr>
						</table>
						</form>
					</div>
					<a href="adv-search.php">click here for advanced search</a>
				</div>
		<?php
			if(!isset($_SESSION['LogdUsrDet']))
			{
		?>
				<div id="box3">
					<h4>Login Here</h4>
					<div style="height:100px;">
						<form name="UserLogIn" method="post" action="<?php echo $page;?>" onsubmit="return ValidateUserLogIn()">
						<input type="hidden" name="Operation" value="UserLogIn" />
						<input type="hidden" name="ShownLimit" value="<?php echo $ShownLimit;?>" />
						<table style="font-size:11px; font-weight:bold; color:#666666;" align="center">
							<tr>
								<td align="right">
									Email ID:
								</td>
								<td>
									<input type="text" name="txtUsrNme" value="<?php if(isset($_POST['txtUsrNme'])){echo $_POST['txtUsrNme'];}?>" maxlength="35" style="border:#666666 solid 1px; border-radius:3px; width:147px; height:15px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Password:
								</td>
								<td>
									<input type="password" name="txtPswd" value="<?php if(isset($_POST['txtPswd'])){echo $_POST['txtPswd'];}?>" maxlength="35" style="border:#666666 solid 1px; border-radius:3px; width:147px; height:15px;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
								<span id="LogErr" style="color:#FF0000; font-size:10px; font-weight:normal;"><?php if($LogErr!=""){echo $LogErr;}?></span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="Log In" style="border:#666666 solid 1px; border-radius:3px; width:70px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" />
								</td>
							</tr>
						</table>
						<?php
										if($page=="product.php")
										{
										?>
										<input type="hidden" name="op" value="<?php echo $op;?>" />
										<?php
										if(isset($_POST['ProductID']))
										{
										?>
										<input type="hidden" name="ProductID" value="<?php echo $_POST['ProductID'];?>" />
										<?php
										}
										if(isset($_POST['ProSearch']))
										{
										?>
										<input type="hidden" name="ProSearch" value="<?php echo $_POST['ProSearch'];?>" />
										<?php
										}
										if(isset($_POST['ProCat']))
										{
										?>
										<input type="hidden" name="ProCat" value="<?php echo $_POST['ProCat'];?>" />
										<?php
										}
										}
										?>
						</form>
					</div>
					<a href="signup.php">New user? click here to sign up</a>
				</div>
		<?php
			}
			else if($_SESSION['LogdUsrDet'][0]=="GenUsr")
			{
				mysql_select_db("shop");
				$result=mysql_query("SELECT `name` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'");
				if($row=mysql_fetch_array($result))
				{
					$name=$row['name'];
				}
				$temp="";
				$temp=$temp.strpos($name, " ");
				if($temp)
				{
					$FirstName=substr($name, 0, strpos($name, " "));
				}
				else
				{
					$FirstName=$name;
				}
		?>
				<div id="box3">
					<h4>Welcome <?php echo $FirstName;?></h4>
					<div style="height:100px; padding:0 10px 0 10px; text-align:justify;">
						<p>
							Please choose the products, you want to buy and order them after adding them to your cart. Don't forget to log out once you are done.
						</p>
						<table width="90%" align="center">
							<tr>
								<td align="left">
									<form action="setting.php">
										<input type="submit" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" value="Account Setting" />
									</form>
								</td>
								<td align="right">
									<form action="logout.php">
										<input type="submit" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" value="Log Out" />
									</form>
								</td>
							</tr>
						</table>
					</div>
				</div>
		<?php
			}
			else if($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin")
			{
		?>
				<div id="box3">
					<h4>Welcome Administrator</h4>
					<div style="height:100px; padding:0 10px 0 10px; text-align:justify;">
						<p>
							Here you are being provided a general interface like other users just for check up. To perform administrative operations please go to control panel. Don't forget to log out once you are done.
						</p>
						<table width="90%" align="center">
							<tr>
								<td align="left">
									<form action="admin/control.php">
										<input type="submit" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" value="Control Panel" />
									</form>
								</td>
								<td align="right">
									<form action="logout.php">
										<input type="submit" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" value="Log Out" />
									</form>
								</td>
							</tr>
						</table>
					</div>
				</div>
		<?php
			}
		?>
			</div>
			<div id="lower-content">
				<div id="main-content">