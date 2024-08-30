<?php
	session_start();
	$page="image-upload.php";
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
		include("admin-files/admin-top.php");
?>
		<h4>Product Image Uploader (jpg, gif, bmp or png Formats Only)</h4>
<?php
$error="";
if(isset($_FILES["file"]["name"]))
{
	$validate = "".strpos($_FILES["file"]["name"], "'")."";
	$id=substr($_FILES["file"]["name"], 0, strpos($_FILES["file"]["name"], "."));
	if((!$_FILES["file"]["name"])||($_FILES["file"]["name"]==""||$_FILES["file"]["name"]==null))
	{
	 	$error="please choose a file";
	}
	else if (!(($_FILES["file"]["type"] == "image/gif")||($_FILES["file"]["type"] == "image/jpeg")||($_FILES["file"]["type"] == "image/jpg")||($_FILES["file"]["type"] == "image/bmp")||($_FILES["file"]["type"] == "image/png")))
	{
	 	$error="please choose an image file of type jpg, gif, bmp or png";
	}
	else if ($_FILES["file"]["size"] > 8192000)
	{
	 	$error="please choose a file of size less than 8MB";
	}
	else if ($validate!="")
	{
	 	$error="The image name '".$id."' doesn't match with any Product ID.";
	}
	else if ($_FILES["file"]["error"] > 0)
	{
	   	$error="Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		include("../include/connect-database.php");
		mysql_select_db("shop");
		$result=mysql_query("SELECT img FROM `product` where `ID`='".$id."'");
		if($row=mysql_fetch_array($result))
		{
			if($row['img']==$_FILES["file"]["name"])
			{
				$error="The Product ID '".$id."' already have an image.";
				?>
					The Product ID '<?php echo $id;?>' already have the image below:<br />
					<img src="../product-img/<?php echo $_FILES["file"]["name"];?>"  style="width:360px; height:360px; position:relative;"/><br />
				<?php
			}
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"], "../bulk-img/" . $_FILES["file"]["name"]);
include 'admin-files/resize.image.class.php';
$image = new Resize_Image;
$image->new_width = 350;
$image->new_height = 300;
$image->image_to_resize = "../bulk-img/" . $_FILES["file"]["name"];
$image->ratio = true;
$image->new_image_name = $id;
$image->save_folder = '../product-img/';
$process = $image->resize();
if($process['result'] && $image->save_folder)
{
}
				mysql_query("UPDATE `shop`.`product` SET `img` = '".$id.".jpg' WHERE `product`.`id` = '".$id."'");
				?>
					<img src="../product-img/<?php echo $id.".jpg";?>"  style="max-width:360px; max-height:360px; position:relative;"/><br />
					<label style='color:#009900;font-weight:bold;'>Image added successfully for Product ID: <?php echo $id;?></label><br /><br />
					<form name='ViewDetails' method='post' action='../product.php'>
						<input type='hidden' name='Operation' value='ViewDetails' />
						<input type='hidden' name='ProductID' value='<?php echo $id;?>' />
						<input type='submit' value='View As General User' style='border:#666666 solid 1px; border-radius:3px; height:25px; padding-right:-10px;background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' />
					</form><br />
				<?php
			}
		}
		else
		{
			$error="The image name '".$id."' doesn't match with any Product ID.";
		}
				
	}
}
if((!isset($_FILES["file"]["name"]))||($error!=""))
{
?>
	<form name="UploadImage" action="image-upload.php" method="post" enctype="multipart/form-data">
		<label style="color:#444444; font-weight:bold;">Choose Image File: </label><input type="file" name="file" id="file" value="<?php echo $_FILES["file"];?>" />
		<?php if($error!=""){echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."<br /></label>";}?>
		<input type="submit" value="Upload File" style="margin-top:5px;" />
	</form><br /><br />
		<h4>Instructions for uploading images:</h4>
		<label style="color:#444444; font-weight:bold;">STEP 1:</label> Choose an image file for a spcific product.<br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 2:</label> Rename the image file to the Product ID of the product for witch you want to upload the image.<br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 3:</label> Browse the image file and upload it.<br /><br />
		<h4>Restrictions on images:</h4>
		<label style="color:#444444; font-weight:bold;">1)</label> The file must be an image file with extensions '.jpg', '.gif', '.bmp' or '.png'.<br /><br />
		<label style="color:#444444; font-weight:bold;">2)</label> The file size for the image must be less than 8MB.<br /><br />
		<label style="color:#444444; font-weight:bold;">3)</label> The file name for the image should match with the Product ID of some uploaded Product.<br /><br />
		<label style="color:#444444; font-weight:bold;">4)</label> The name of the image should not match with the Product ID of some Product for which already an image has been added.<br /><br />
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