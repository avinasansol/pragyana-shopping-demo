<?php
	session_start();
	$page="excel-upload.php";
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
		<h4>Product Database Uploader (Excel 97-2003 Workbook Format Only)</h4>
<?php
$error="";
if(isset($_FILES["file"]["name"]))
{
	if((!$_FILES["file"]["name"])||($_FILES["file"]["name"]==""||$_FILES["file"]["name"]==null))
	{
	 	$error="please choose a file";
	}
	else if ($_FILES["file"]["type"] != "application/vnd.ms-excel")
	{
	 	$error="please choose an excel file with '.xls' extension";
	}
	else if (!($_FILES["file"]["size"] < 2048000))
	{
	 	$error="please choose a file of size less than 2MB";
	}
	else if ($_FILES["file"]["error"] > 0)
	{
	   	$error="Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		include("../include/connect-database.php");
		mysql_select_db("shop");
		require_once 'Excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($_FILES["file"]["tmp_name"]);
	    $date = getdate();
		for ($x = 1; $x <= count($data->sheets[0]["cells"]); $x++)
		{
			$id="";
			$name="";
			$desc="";
			$price=""; 
			$catagory="";
			$added=0;
			$AddErr="Could not be added as there was no Product";
			if(!isset($data->sheets[0]["cells"][$x][1]))
			{
				$AddErr=$AddErr." ID,";
			}
			else
			{
				$id = $data->sheets[0]["cells"][$x][1];
			}
			if(!isset($data->sheets[0]["cells"][$x][2]))
			{
				$AddErr=$AddErr." Name,";
			}
			else
			{
				$name = $data->sheets[0]["cells"][$x][2];
			}
			if(!isset($data->sheets[0]["cells"][$x][3]))
			{
				$AddErr=$AddErr." Description,";
			}
			else
			{
				$desc = $data->sheets[0]["cells"][$x][3];
			}
			if(!isset($data->sheets[0]["cells"][$x][4]))
			{
				$AddErr=$AddErr." Price,";
			}
			else
			{
				$price = $data->sheets[0]["cells"][$x][4];
			}
			if(!isset($data->sheets[0]["cells"][$x][5]))
			{
				$AddErr=$AddErr." Catagory,";
			}
			else
			{
				$catagory = $data->sheets[0]["cells"][$x][5];
			}
			if(!isset($data->sheets[0]["cells"][$x][6]))
			{
				$AddErr=$AddErr." Quantity,";
			}
			else
			{
				$quantity = $data->sheets[0]["cells"][$x][6];
			}
			if(substr($AddErr, (strlen($AddErr)-1), 1)==",")
			{
				$AddErr[(strlen($AddErr)-1)]=".";
			}
			else
			{
				$AddErr="";
				if(preg_match ('/[^a-zA-Z0-9 -_]/i', $id))
				{
					$AddErr="Could not be added as the Product ID(".$id.") does not contain alphanumeric characters only.";
				}
				else if(strlen($id)>15)
				{
					$AddErr="Could not be added as the Product ID(".$id.") is more than 15 characters long.";
				}
				else
				{
					$result=mysql_query("SELECT * FROM `product` where `ID`='".$id."'");
					if($row=mysql_fetch_array($result))
					{
						$AddErr="Could not be added as a product with same Product ID(".$id.") already added on ".$row['date'].".";
					}
					else if(!preg_match('/[A-Za-z]/', $name))
					{
						$AddErr="Could not be added as the Product Name(".$name.") does not contain atleast one letter.";
					}
					else if(strlen($name)>30)
					{
						$AddErr="Could not be added as the Product Name(".$name.") is more than 30 characters long.";
					}
					else if(strlen($price)>15)
					{
						$AddErr="Could not be added as the Product Price(".$price.") is more than 15 characters long.";
					}
					else if(!preg_match('/^[0-9]{1,}$/', $price))
					{
						$AddErr="Could not be added as the Product Price is not valid number.";
					}
					else if(!preg_match('/[A-Za-z]/', $catagory))
					{
						$AddErr="Could not be added as the Product Catagory(".$catagory.") does not contain atleast one letter.";
					}
					else if(strlen($catagory)>20)
					{
						$AddErr="Could not be added as the Product Catagory(".$catagory.") is more than 20 characters long.";
					}
					else if(strlen($quantity)>15)
					{
						$AddErr="Could not be added as the Product Quantity(".$quantity.") is more than 15 characters long.";
					}
					else if(!preg_match('/^[0-9]{1,}$/', $quantity))
					{
						$AddErr="Could not be added as the Product Quantity is not valid number.";
					}
					else if($x!=1)
					{
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
						
						$sql="INSERT INTO `shop`.`product` (`id`, `name`, `desc`, `price`, `qty`, `catagory`, `img`, `date`) VALUES ('".$id."', '".$name."', '".$desc."', '".$price."', '".$quantity."', '".$catagory."', '', CURDATE())";
						mysql_query($sql);
						$added=1;
					}
				}
				if($x==1)
				{
					$AddErr="Expected to be column names.";
				}
			}
			?>
			<label style='font-weight:bold;'>Row <?php echo $x;?>: </label>
			<?php
			if($added==0)
			{
			?>
			<label style='color:#FF0000'><?php echo $AddErr;?></label><br />
			<?php
			}
			else
			{
			?>
			<label style='color:#009900;font-weight:bold;'>Producted added successfully.</label><br />
			<?php
			}
			if($x!=1)
			{
			?>
			<label style='font-size:11px; font-weight:bold; color:#666666;'>ID: </label><?php echo $id;?>,<br />
			<label style='font-size:11px; font-weight:bold; color:#666666;'>Name: </label><?php echo $name;?>,<br />
			<label style='font-size:11px; font-weight:bold; color:#666666;'>Price: </label><?php echo $price;?>,<br />
			<label style='font-size:11px; font-weight:bold; color:#666666;'>Catagory: </label><?php echo $catagory;?>,<br />
			<label style='font-size:11px; font-weight:bold; color:#666666;'>Upload Date: </label><?php echo $date['year']."-".$date['month']."-".$date['mday'];?>,<br />
			<label style='font-size:11px; font-weight:bold; color:#666666;'>Description: </label><?php echo $desc;?><br />
			<?php
			}
			?>
			<br />
			<?php
			if($added==1)
			{
			?>
			<form name='ViewDetails' method='post' action='../product.php'>
				<input type='hidden' name='Operation' value='ViewDetails' />
				<input type='hidden' name='ProductID' value='<?php echo $id;?>' />
				<input type='submit' value='View As General User' style='border:#666666 solid 1px; border-radius:3px; height:25px; padding-right:-10px;background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;' />
			</form><br /><br />
			<?php
			}
			?>
			<?php
		}
	}
}
if((!isset($_FILES["file"]["name"]))||($error!=""))
{
?>
	<form name="UploadExcel" action="excel-upload.php" method="post" enctype="multipart/form-data">
		<label style="color:#666666; font-weight:bold;">Choose Excel File: </label><input type="file" name="file" id="file" />
		<?php if($error!=""){echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."<br /></label>";}?>
		<input type="submit" value="Upload File" style="margin-top:5px;" />
	</form><br /><br />
		<h4>Instructions for uploading excel:</h4>
		<label style="color:#444444; font-weight:bold;">STEP 1:</label> You need to have Microsoft Office installed in your PC.<br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 2:</label> Go to All Programs -> Microsoft Office -> Microsoft Office Excel. A new excel window will be open now.<br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 3:</label> 
		In Sheet1 of the excel insert the following data in the 1st row's	Column A, B, C, D, E and F respectively: <br />
		Product ID, Name, Description, Price, Category and Quantity as shown below:<br />
		<br />
		<img src="admin-files/excel-example.jpg" style='border:0; width:600px; height:300px;' /><br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 4:</label> Now insert your product's informations in the excel rows considering first row as heading as shown below:<br /><br />
		<img src="admin-files/excel-product-example.jpg" style='border:0; width:600px; height:300px;' /><br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 5:</label> Now Go to file -> Save As -> Excel 97-2003 Workbook as shown below:<br /><br />
		<img src="admin-files/excel-save-example.jpg" style='border:0; width:600px; height:500px;' /><br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 6:</label> Now give some name to the file and click save.<br /><br />
		<label style="color:#444444; font-weight:bold;">STEP 7:</label> Browse the excel file and upload it.<br /><br />
		<label style="color:#444444; font-weight:bold;">NOTE: </label>You can download a standared excel file from <a href="admin-files/product.xls">here</a> and upload after filling data in it.<br /><br />
		<h4>Restrictions on Excel File:</h4>
		<label style="color:#444444; font-weight:bold;">1)</label> The file must be an excel file with extensions '.xls' saved as 97-2003 Workbook format.<br /><br />
		<label style="color:#444444; font-weight:bold;">2)</label> The file size for the excel must be less than 2MB.<br /><br />
		<label style="color:#444444; font-weight:bold;">NOTE: </label>There is no restriction on file name of the excel.<br /><br />
		<h4>Restrictions on Excel Rows:</h4>
		<label style="color:#444444; font-weight:bold;">1)</label> 
		A row must contain all the informations viz: Product ID, Name, Description, Price, Category and Quantity.<br />
		<br />
		<label style="color:#444444; font-weight:bold;">2)</label> The Product ID should not match with the Product ID of an already added Product.<br /><br />
		<label style="color:#444444; font-weight:bold;">3)</label> The Product ID should be alphanumeric only.<br /><br />
		<label style="color:#444444; font-weight:bold;">4)</label> The Product ID should not be more than 15 characters long.<br /><br />
		<label style="color:#444444; font-weight:bold;">5)</label> The Product Name should contain atleast 1 English Letter.<br /><br />
		<label style="color:#444444; font-weight:bold;">6)</label> The Product Name should not be more than 30 characters long.<br /><br />
		<label style="color:#444444; font-weight:bold;">7)</label> The Product Price should be numbers only.<br /><br />
		<label style="color:#444444; font-weight:bold;">8)</label> The Product Price should not be more than 15 characters long.<br /><br />
        <label style="color:#444444; font-weight:bold;">9)</label> The Product Catagory should contain atleast 1 English Letter.<br /><br />
		<label style="color:#444444; font-weight:bold;">10)</label> The Product Catagory should not be more than 20 characters long.<br /><br />
		<label style="color:#444444; font-weight:bold;">11)</label> The Product Quantity should be numbers only. <br /><br />
		<label style="color:#444444; font-weight:bold;">12)</label> The Product Quantity should not be more than 15 characters long.<br /><br />
		<label style="color:#444444; font-weight:bold;">NOTE: </label>If any of the above mentioned Restrictions is found in Excel Rows, the informations of the product mentioned in that particular row will not be added.<br /><br />
<script type="text/javascript"> 
$(document).ready(function(){
    $("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
});
</script>
<?php
}
?>
				
<?php
		include("admin-files/admin-bottom.php");
	}
?>