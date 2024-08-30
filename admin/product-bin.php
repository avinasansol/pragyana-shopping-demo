<?php
	session_start();
	$page="product-bin.php";
	$UpErr="";
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
		include("admin-files/admin-top.php");
?>
	<h4>Product-Bin (Product Editer)</h4>
<?php
if(isset($_REQUEST['ProDuctID']))
{
	if(($_REQUEST['ProDuctID']==""||$_REQUEST['ProDuctID']==null))
	{
	 	$error="please enter a Product ID";
	}
	else
	{
		include("../include/connect-database.php");
		mysql_select_db("shop");
		if(isset($_POST['ProUpDate']) && isset($_POST['ProDuctID']))
		{
			if(($_POST['ProUpDate']=="UpdateImage")&&(isset($_FILES["file"]["name"])))
			{
				if((!$_FILES["file"]["name"])||($_FILES["file"]["name"]==""||$_FILES["file"]["name"]==null))
				{
				 	$UpErr="please choose a file";
				}
				else if (!(($_FILES["file"]["type"] == "image/gif")||($_FILES["file"]["type"] == "image/jpeg")||($_FILES["file"]["type"] == "image/jpg")||($_FILES["file"]["type"] == "image/bmp")||($_FILES["file"]["type"] == "image/png")))
				{
				 	$UpErr="please choose an image file of type jpg, gif, bmp or png";
				}
				else if ($_FILES["file"]["size"] > 8192000)
				{
				 	$UpErr="please choose a file of size less than 8MB";
				}
				else if ($_FILES["file"]["error"] > 0)
				{
				   	$UpErr="Return Code: " . $_FILES["file"]["error"] . "<br />";
				}
				else
				{
					$BulkFile="../bulk-img/".$_POST['ProDuctID'].".".substr($_FILES["file"]["type"], (strpos($_FILES["file"]["type"], "/")+1), strlen($_FILES["file"]["type"]));
					if(file_exists($BulkFile))
					{
						function gen_pass($len = 10)
						{
							return substr(md5(rand().rand()), 0, $len);
						}
						$pass=gen_pass();
						rename($BulkFile, "../bulk-img/".$_POST['ProDuctID']."_".$pass.".".substr($_FILES["file"]["type"], (strpos($_FILES["file"]["type"], "/")+1), strlen($_FILES["file"]["type"])));
					}
					move_uploaded_file($_FILES["file"]["tmp_name"], $BulkFile);
					include 'admin-files/resize.image.class.php';
					$image = new Resize_Image;
					$image->new_width = 350;
					$image->new_height = 300;
					$image->image_to_resize = $BulkFile;
					$image->ratio = true;
					$image->new_image_name = $_POST['ProDuctID'];
					$image->save_folder = '../product-img/';
					$process = $image->resize();
					if($process['result'] && $image->save_folder)
					{
					}
					mysql_query("UPDATE `shop`.`product` SET `img` = '".$_POST['ProDuctID'].".jpg' WHERE `product`.`id` = '".$_POST['ProDuctID']."'"); 
				}
			}
			else if(($_POST['ProUpDate']=="UpdateName")&&(isset($_POST['ProName'])))
			{
				if(($_POST['ProName']=="")||($_POST['ProName']==null))
				{
					$UpErr="Please provide a Product Name.";
				}
				else if(!preg_match('/[A-Za-z]/', $_POST['ProName']))
				{
					$UpErr="Product Name should contain atleast one english letter.";
				}
				else if(strlen($_POST['ProName'])>30)
				{
					$UpErr="Product Name should not be more than 30 characters long.";
				}
				else 
				{
					$name=$_POST['ProName'];
					$temp=$name;
					$validate = "".strpos($temp, "'")."";
					$pos=strpos($temp, "'");
					$chPos=$pos;
					$loop=0;
					while($validate!="")
					{
						$name=$name."x";
						for($t=(strlen($name)-1);$t>=$chPos;$t--)
						{
							$name[($t+1)]=$name[$t];
						}
						$temp=substr($temp, ($pos+1), strlen($temp));
						echo $temp."<br />";
						$validate = "".strpos($temp, "'")."";
						$pos=strpos($temp, "'");
						$chPos=$chPos+$pos+2;
						$loop++;
					}
					$name=substr($name, 0, (strlen($name)-$loop));
					if(!mysql_query("UPDATE `shop`.`product` SET `name` = '".$name."' WHERE `product`.`id` = '".$_POST['ProDuctID']."'"))
					{
						$UpErr="Product could not be updated.";
					}
				}
			}
			else if(($_POST['ProUpDate']=="UpdatePrice")&&(isset($_POST['ProPrice'])))
			{
				if(($_POST['ProPrice']=="")||($_POST['ProPrice']==null))
				{
					$UpErr="Please provide some Price for the Product.";
				}
				else if(strlen($_POST['ProPrice'])>15)
				{
					$UpErr="Product Price should not be more than 15 characters long.";
				}
				else if(!preg_match('/^[0-9]{1,}$/', $_POST['ProPrice']))
				{
					$UpErr="Product Price should be a valid number.";
				}
				else if(!mysql_query("UPDATE `shop`.`product` SET `price` = '".$_POST['ProPrice']."' WHERE `product`.`id` = '".$_POST['ProDuctID']."'"))
				{
					$UpErr="Product could not be updated.";
				}
			}
			else if(($_POST['ProUpDate']=="UpdateCatagory")&&(isset($_POST['ProCatGry'])))
			{
				if(($_POST['ProCatGry']=="")||($_POST['ProCatGry']==null))
				{
					$UpErr="Please provide a Product Catagory.";
				}
				else if(!preg_match('/[A-Za-z]/', $_POST['ProCatGry']))
				{
					$UpErr="Product Catagory should contain atleast one english letter.";
				}
				else if(strlen($_POST['ProCatGry'])>20)
				{
					$UpErr="Product Catagory should not be more than 20 characters long.";
				}
				else 
				{
					$catagory=$_POST['ProCatGry'];
					$temp=$catagory;
					$validate = "".strpos($temp, "'")."";
					$pos=strpos($temp, "'");
					$chPos=$pos;
					$loop=0;
					while($validate!="")
					{
					$catagory=$catagory."x";
						for($t=(strlen($catagory)-1);$t>=$chPos;$t--)
						{
							$catagory[($t+1)]=$catagory[$t];
						}
						$temp=substr($temp, ($pos+1), strlen($temp));
						echo $temp."<br />";
						$validate = "".strpos($temp, "'")."";
						$pos=strpos($temp, "'");
						$chPos=$chPos+$pos+2;
						$loop++;
					}
					$catagory=substr($catagory, 0, (strlen($catagory)-$loop));
					if(!mysql_query("UPDATE `shop`.`product` SET `catagory` = '".$catagory."' WHERE `product`.`id` = '".$_POST['ProDuctID']."'"))
					{
						$UpErr="Product could not be updated.";
					}
				}
			}
			else if(($_POST['ProUpDate']=="UpdateDesc")&&(isset($_POST['ProDesc'])))
			{
				if(($_POST['ProDesc']=="")||($_POST['ProDesc']==null))
				{
					$UpErr="Please provide a Product Description.";
				}
				else 
				{
					$desc=$_POST['ProDesc'];
					$temp=$desc;
					$validate = "".strpos($temp, "'")."";
					$pos=strpos($temp, "'");
					$chPos=$pos;
					$loop=0;
					while($validate!="")
					{
						$desc=$desc."x";
						for($t=(strlen($desc)-1);$t>=$chPos;$t--)
						{
							$desc[($t+1)]=$desc[$t];
						}
						$temp=substr($temp, ($pos+1), strlen($temp));
						echo $temp."<br />";
						$validate = "".strpos($temp, "'")."";
						$pos=strpos($temp, "'");
						$chPos=$chPos+$pos+2;
						$loop++;
					}
					$desc=substr($desc, 0, (strlen($desc)-$loop));
					if(!mysql_query("UPDATE `shop`.`product` SET `desc` = '".$desc."' WHERE `product`.`id` = '".$_POST['ProDuctID']."'"))
					{
						$UpErr="Product could not be updated.";
					}
				}
			}
			else if(($_POST['ProUpDate']=="UpdateQty")&&(isset($_POST['ProQty'])))
			{
				if(($_POST['ProQty']=="")||($_POST['ProQty']==null))
				{
					$UpErr="Please provide a Product Quantity.";
				}
				else if(strlen($_POST['ProQty'])>15)
				{
					$UpErr="Product Quantity should not be more than 15 characters long.";
				}
				else if(!preg_match('/^[0-9]{1,}$/', $_POST['ProQty']))
				{
					$UpErr="Product Quantity should be a valid number.";
				}
				else if(!mysql_query("UPDATE `shop`.`product` SET `qty` = '".$_POST['ProQty']."' WHERE `product`.`id` = '".$_POST['ProDuctID']."'"))
				{
					$UpErr="Product could not be updated.";
				}
			}
			else
			{
				$UpErr="Product could not be updated.";
			}
			if($UpErr=="")
			{
				$UpErr="Product updated successfully.";
			}
		}
		$result=mysql_query("SELECT * FROM `product` where `ID`='".$_REQUEST['ProDuctID']."'");
		if($row=mysql_fetch_array($result))
		{
			if(($row['img']!="")||($row['img']!=null))
			{
			echo "<img src='../product-img/".$row['img']."' style='max-width:350px; max-height:300px; border:0px;'  /><br /><br />";
				?>
				<form name="UploadImage" action="product-bin.php" method="post" enctype="multipart/form-data">
					<label style="color:#444444; font-weight:bold;">Change The Image: </label>
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdateImage" />
					<input type="file" name="file" id="file" value="<?php echo $_FILES["file"];?>" />
					<input type="submit" value="Upload Image" style="margin-top:5px;" />
				</form><br />
				<?php
			}
			else
			{
				?>
				Currently, the product doesn't have an image. Please upload an image.<br /><br />
				<form name="UploadImage" action="product-bin.php" method="post" enctype="multipart/form-data">
					<label style="color:#444444; font-weight:bold;">Choose Image File: </label>
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdateImage" />
					<input type="file" name="file" id="file" value="<?php echo $_FILES["file"];?>" />
					<input type="submit" value="Upload Image" style="margin-top:5px;" />
				</form><br />
				<?php
			}
			?>
			<table align="center">
			<tr>
				<td align="right" width="50%">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Product ID: </label>
				</td>
				<td align="left" width="50%">
					<?php echo "".$row["id"];?>
				</td>
			</tr>
			<tr>
				<td align="right">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Upload Date: </label>
				</td>
				<td align="left">
					<?php echo "".$row["date"];?>
				</td>
			</tr>
			<tr>
				<td align="right">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Name: </label>
				</td>
				<td align="left">
				<form action="product-bin.php" method="post">
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="text" name="ProName" maxlength="30" value="<?php echo "".$row["name"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdateName" />
					<input type="submit" title="Update The Product Name" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
				</form>
				</td>
			</tr>
			<tr>
				<td align="right">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Price(Rs): </label>
				</td>
				<td align="left">
				<form action="product-bin.php" method="post">
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="text" name="ProPrice" maxlength="15" value="<?php echo "".$row["price"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdatePrice" />
					<input type="submit" title="Update The Product Price" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
				</form>
				</td>
			</tr>
			<tr>
				<td align="right">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Catagory: </label>
				</td>
				<td align="left">
				<form action="product-bin.php" method="post">
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="text" name="ProCatGry" maxlength="20" value="<?php echo "".$row["catagory"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdateCatagory" />
					<input type="submit" title="Update The Product Catagory" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
				</form>
				</td>
			</tr>
			<tr>
				<td align="right">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Details: </label>
				</td>
				<td align="left">
				<form action="product-bin.php" method="post">
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="text" name="ProDesc" value="<?php echo "".$row["desc"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdateDesc" />
					<input type="submit" title="Update The Product Description" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
				</form>
				</td>
			</tr>
			<tr>
				<td align="right">
					<label style='font-size:11px; font-weight:bold; color:#666666;'>Available Quantity: </label>
				</td>
				<td align="left">
				<form action="product-bin.php" method="post">
					<input type="hidden" name="ProDuctID" value="<?php echo "".$row["id"];?>" />
					<input type="text" name="ProQty" maxlength="15" value="<?php echo "".$row["qty"];?>" />
					<input type="hidden" name="ProUpDate" value="UpdateQty" />
					<input type="submit" title="Update The Available Quantity" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
				</form>
				</td>
			</tr>
			</table>
			<?php
			if($UpErr!="")
			{
			?>
			<br /><label style='color:#FF0000; font-size:11px;'><?php echo $UpErr;?></label><br />
			<?php
			}
			echo "<br /><br />";
		}
		else
		{
	 		$error="The Product ID is not valid.";
		}
	}
}
if((!isset($_REQUEST['ProDuctID']))||($error!=""))
{
if(!isset($_REQUEST['View']))
{
?>
	<form name="ProductBin" action="product-bin.php" method="get">
		<label style="color:#444444; font-weight:bold;">Enter Product Code: </label>
		<input type="text" name="ProDuctID" value="" />
		<?php if($error!=""){echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."<br /></label>";}?>
		<input type="submit" value="View Status" style="margin-top:5px;" />
	</form><br />
	OR<br /><br /><br />
	<a style='text-decoration:none; font-weight:bold; text-transform:uppercase; color:#990000; border:#666666 solid 1px; border-radius:15px; padding:10px 20px 10px 20px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' href="product-bin.php?View=All">Load All Products' List</a><br /><br />
<?php
}
else if((isset($_REQUEST['View'])) && ($_REQUEST['View']=="All"))
{
	include("../include/connect-database.php");
	mysql_select_db("shop");
	$sql="SELECT `id`, `name`, `img` FROM `product` ORDER BY `date` DESC";
	$result=mysql_query($sql);
	?>
	<table align="center" cellpadding="5" cellspacing="5" style="max-width:90%;">
	<tr style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
		<td>
			Product Image
		</td>
		<td>
			Product ID
		</td>
		<td align="left">
			Product Name
		</td>
		<td>
			Details
		</td>
	</tr>
	<?php
	while($row=mysql_fetch_array($result))
	{
	?>
	<tr height="50px">
		<td>
			<?php if(($row['img']!="")||($row['img']!=null)){echo "<img src='../product-img/".$row['img']."' style='max-width:48px; max-height:48px;' />";}else{echo "NO IMAGE";}?>
		</td>
		<td>
			<?php echo $row['id'];?>
		</td>
		<td align="left">
			<?php echo $row['name'];?>
		</td>
		<td>
	<form name="ProductBin" action="product-bin.php" method="get">
		<input type="hidden" name="ProDuctID" value="<?php echo $row['id'];?>" />
		<input type="submit" value="View Status" style='text-decoration:none; color:#990000; border:#666666 solid 1px; border-radius:5px; padding:4px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' />
	</form>
		</td>
	</tr>
	<?php
	}
	?>
	</table>
	<?php
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
	if($UpErr!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $UpErr;?>");
	</script>
	<?php
	}
?>