<?php
	session_start();
	$page="setting.php";
	if((!isset($_SESSION['LogdUsrDet']))||($_SESSION['LogdUsrDet'][0]=="ContrlrAdmin"))
	{
		header("Location: index.php");
	}
	include("include/connect-database.php");
	mysql_select_db("shop");
	$ErrUpdateInfo="please provide your ";
	$ErrUpdateContact="please provide your ";
	$ChangePassword="";
	$ChangeEmail="please provide ";
	if((isset($_POST['UpdateInfo']))&&($_POST['UpdateInfo']=="Update Personel Details"))
	{
		if((!isset($_POST['FirstName']))||($_POST['FirstName']=="")||($_POST['FirstName']==null))
		{
			$ErrUpdateInfo=$ErrUpdateInfo."full name, ";
		}
		if((!isset($_POST['LastName']))||($_POST['LastName']=="")||($_POST['LastName']==null))
		{
			$ErrUpdateInfo=$ErrUpdateInfo."last name, ";
		}
		if((!isset($_POST['Gender']))||($_POST['Gender']=="")||($_POST['Gender']==null))
		{
			$ErrUpdateInfo=$ErrUpdateInfo."gender, ";
		}
		if((!isset($_POST['DateBirth']))||($_POST['DateBirth']=="")||($_POST['DateBirth']==null))
		{
			$ErrUpdateInfo=$ErrUpdateInfo."birth date, ";
		}
		if((!isset($_POST['MonthBirth']))||($_POST['MonthBirth']=="")||($_POST['MonthBirth']==null))
		{
			$ErrUpdateInfo=$ErrUpdateInfo."birth month, ";
		}
		if((!isset($_POST['YearBirth']))||($_POST['YearBirth']=="")||($_POST['YearBirth']==null))
		{
			$ErrUpdateInfo=$ErrUpdateInfo."birth year, ";
		}
		if($ErrUpdateInfo!="please provide your ")
		{
			$ErrUpdateInfo[(strlen($ErrUpdateInfo)-2)]=".";
		}
		else
		{
			$sql="UPDATE `user` SET `name`='".$_POST['FirstName']."', `last_name`='".$_POST['LastName']."', `gender`='".$_POST['Gender']."', `dob`='".$_POST['YearBirth']."-".$_POST['MonthBirth']."-".$_POST['DateBirth']."' WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
			mysql_query($sql);
			$ErrUpdateInfo="Your Personal Details have been updated successfully.";
		}
	}
	if((isset($_POST['UpdateContact']))&&($_POST['UpdateContact']=="Update Contact Information"))
	{
		if((!isset($_POST['StreetAdd']))||($_POST['StreetAdd']=="")||($_POST['StreetAdd']==null))
		{
			$ErrUpdateContact=$ErrUpdateContact."street address, ";
		}
		if((!isset($_POST['PostCode']))||($_POST['PostCode']=="")||($_POST['PostCode']==null))
		{
			$ErrUpdateContact=$ErrUpdateContact."postal code, ";
		}
		if((!isset($_POST['City']))||($_POST['City']=="")||($_POST['City']==null))
		{
			$ErrUpdateContact=$ErrUpdateContact."city, ";
		}
		if((!isset($_POST['State']))||($_POST['State']=="")||($_POST['State']==null))
		{
			$ErrUpdateContact=$ErrUpdateContact."state, ";
		}
		if((!isset($_POST['Country']))||($_POST['Country']=="")||($_POST['Country']==null))
		{
			$ErrUpdateContact=$ErrUpdateContact."country, ";
		}
		if((!isset($_POST['PhNo']))||($_POST['PhNo']=="")||($_POST['PhNo']==null))
		{
			$ErrUpdateContact=$ErrUpdateContact."phone number, ";
		}
		if($ErrUpdateContact!="please provide your ")
		{
			$ErrUpdateContact[(strlen($ErrUpdateContact)-2)]=".";
		}
		else if(!preg_match('/^[0-9]{1,}$/', $_POST['PhNo']))
		{
			$ErrUpdateContact="please provide a valid phone number.";
		}
		else
		{
			$sql="UPDATE `user`  SET `add`='".$_POST['StreetAdd']."', `pin_code`='".$_POST['PostCode']."', `city`='".$_POST['City']."', `state`='".$_POST['State']."', `country`='".$_POST['Country']."', `phno`='".$_POST['PhNo']."' WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
			mysql_query($sql);
			$ErrUpdateContact="Your Contact Informations have been updated successfully.";
		}
	}
	if((isset($_POST['ChangePassword']))&&($_POST['ChangePassword']=="Change Password"))
	{
		if(((!isset($_POST['OldPswd']))||($_POST['OldPswd']=="")||($_POST['OldPswd']==null))||((!isset($_POST['NewPswd']))||($_POST['NewPswd']=="")||($_POST['NewPswd']==null)))
		{
			$ChangePassword="please provide both your old and new passwords";
		}
		else
		{
			$sql="SELECT  `password` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
			$result=mysql_query($sql);
			if($row=mysql_fetch_array($result))
			{
				if($row['password']!=$_POST['OldPswd'])
				{
					$ChangePassword="Incorrect Old Password.";
				}
				else
				{
					$sql="UPDATE `user`  SET `password`='".$_POST['NewPswd']."' WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
					mysql_query($sql);
					$ChangePassword="Password changed successfully.";
				}
			}
		}
	}
	if((isset($_POST['ChangeEmail']))&&($_POST['ChangeEmail']=="Change Email-ID"))
	{
		if((!isset($_POST['EmailID']))||($_POST['EmailID']=="")||($_POST['EmailID']==null))
		{
			$ChangeEmail=$ChangeEmail."email id, ";
		}
		if((!isset($_POST['ConEmailID']))||($_POST['ConEmailID']=="")||($_POST['ConEmailID']==null))
		{
			$ChangeEmail=$ChangeEmail."confirm email, ";
		}
		if((!isset($_POST['PswD']))||($_POST['PswD']=="")||($_POST['PswD']==null))
		{
			$ChangeEmail=$ChangeEmail."your password, ";
		}
		if($ChangeEmail!="please provide ")
		{
			$ChangeEmail[(strlen($ChangeEmail)-2)]=".";
		}
		else if(!(preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/', $_POST['EmailID'])))
		{
			$ChangeEmail="please provide a valid email id.";
		}
		else if($_POST['EmailID']!=$_POST['ConEmailID'])
		{
			$ChangeEmail="confirm email id doesn't match with email id.";
		}
		else
		{
			$sql="SELECT  `password` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
			$result=mysql_query($sql);
			if($row=mysql_fetch_array($result))
			{
				if($row['password']!=$_POST['PswD'])
				{
					$ChangeEmail="Incorrect Password.";
				}
				else
				{
					$sql="UPDATE `user`  SET `username`='".$_POST['EmailID']."' WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
					if(mysql_query($sql))
					{
						$sql="RENAME TABLE `shop`.`cart_".$_SESSION['LogdUsrDet'][1]."` TO `shop`.`cart_".$_POST['EmailID']."`";
						mysql_query($sql);
						$sql="RENAME TABLE `shop`.`order_".$_SESSION['LogdUsrDet'][1]."` TO `shop`.`order_".$_POST['EmailID']."`";
						mysql_query($sql);
						$sql="RENAME TABLE `shop`.`deliver_".$_SESSION['LogdUsrDet'][1]."` TO `shop`.`deliver_".$_POST['EmailID']."`";
						mysql_query($sql);
						$_SESSION['LogdUsrDet'][1]=$_POST['EmailID'];
						$ChangeEmail="Email ID changed successfully.";
					}
				}
			}
		}
	}
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Account Settings</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
					<?php
					$sql="SELECT  `username`, `name`, `last_name`, `gender`, `dob`, `org`, `add`, `pin_code`, `city`, `state`, `country`, `phno` FROM `user` WHERE `username`='".$_SESSION['LogdUsrDet'][1]."'";
					$result=mysql_query($sql);
					if($row=mysql_fetch_array($result))
					{
					?>
						<form name="" action="setting.php" method="post">
						<table align="center" style="font-size:12px; font-weight:bold; color:#666666;">
							<tr>
								<td colspan="2" align="center" style="color:#990000; font-weight:bold; font-size:13px; text-decoration:underline;">
									<br /><br />Change Your Personal Details<br /><br />
								</td>
							</tr>
							<tr>
								<td align="right">
									First Name: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="FirstName" value="<?php echo $row['name'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Last Name: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="LastName" value="<?php echo $row['last_name'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Gender:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<select name="Gender" style="border:#666666 solid 1px; border-radius:3px;">
										<option value="<?php echo $row['gender'];?>"><?php echo $row['gender'];?></option>
										<?php if($row['gender']!="Male"){?><option value="Male">Male</option><?php }?>
										<?php if($row['gender']!="Female"){?><option value="Female">Female</option><?php }?>
									</select>
								</td>
							</tr>
							<tr>
								<td align="right">
									Date of Birth: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<select name="DateBirth" style="border:#666666 solid 1px; border-radius:3px;">
										<option value="<?php echo substr($row['dob'], (strpos($row['dob'], "-")+4), 2);?>"><?php echo substr($row['dob'], (strpos($row['dob'], "-")+4), 2);?></option>
										<?php
											for($i=1;$i<32;$i++)
											{
										?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php
											}
										?>
									</select>
									<select name="MonthBirth" style="border:#666666 solid 1px; border-radius:3px;">
										<option value="<?php echo substr($row['dob'], (strpos($row['dob'], "-")+1), 2);?>"><?php echo substr($row['dob'], (strpos($row['dob'], "-")+1), 2);?></option>
										<?php
											for($i=1;$i<13;$i++)
											{
										?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php
											}
										?>
									</select>
									<select name="YearBirth" style="border:#666666 solid 1px; border-radius:3px;">
										<option value="<?php echo substr($row['dob'], 0, strpos($row['dob'], "-"));?>"><?php echo substr($row['dob'], 0, strpos($row['dob'], "-"));?></option>
										<?php
											for($i=2011;$i>1911;$i--)
											{
										?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<span id="SignUpErr" style="color:#FF0000; font-size:10px; font-weight:normal;">
										<?php
											if($ErrUpdateInfo!="please provide your ")
											{
												echo $ErrUpdateInfo;
											}
										?>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<br /><input type="submit" name="UpdateInfo" value="Update Personel Details" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" />
								</td>
							</tr>
						</table>
						</form>
						<form name="" action="setting.php" method="post">
						<table align="center" style="font-size:12px; font-weight:bold; color:#666666;">
							<tr>
								<td colspan="2" align="center" style="color:#990000; font-weight:bold; font-size:13px; text-decoration:underline;">
									<br /><br />Change Your Contact Informations<br /><br />
								</td>
							</tr>
							<tr>
								<td align="right">
									Street Address: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="StreetAdd" value="<?php echo $row['add'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Postal Code: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="PostCode" value="<?php echo $row['pin_code'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									City: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="City" value="<?php echo $row['city'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									State/Province: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="State" value="<?php echo $row['state'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Country: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<select name="Country" style="border:#666666 solid 1px;width:170px;border-radius:3px;">
										<option value="<?php echo $row['country'];?>"><?php include("include/connect-database.php");
										mysql_select_db("shop");
										$rslt=mysql_query("SELECT `short_name` FROM `country` WHERE `iso2`='".$row['country']."'");
										if($row1=mysql_fetch_array($rslt))
										{echo $row1['short_name'];}
										?>
										<?php
										include("include/connect-database.php");
										mysql_select_db("shop");
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
								<td align="right">
									Phone Number: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="PhNo" value="<?php echo $row['phno'];?>" onclick="this.select()" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<span id="SignUpErr" style="color:#FF0000; font-size:10px; font-weight:normal;">
										<?php
											if($ErrUpdateContact!="please provide your ")
											{
												echo $ErrUpdateContact;
											}
										?>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									
<br /><input type="submit" name="UpdateContact" value="Update Contact Information" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" />
								</td>
							</tr>
						</table>
						</form>
						<form name="" action="setting.php" method="post">
						<table align="center" style="font-size:12px; font-weight:bold; color:#666666;">
							<tr>
								<td colspan="2" align="center" style="color:#990000; font-weight:bold; font-size:13px; text-decoration:underline;">
									<br /><br />Change Your Email ID<br /><br />
								</td>
							</tr>
							<tr>
								<td align="right">
									New E-Mail ID:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="EmailID" value="<?php if((isset($_POST['EmailID']))&&($ChangeEmail!="Email ID changed successfully.")){echo $_POST['EmailID'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Confirm E-Mail ID:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="ConEmailID" value="<?php if((isset($_POST['ConEmailID']))&&($ChangeEmail!="Email ID changed successfully.")){echo $_POST['ConEmailID'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Your Password: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="password" name="PswD" value="" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<span id="SignUpErr" style="color:#FF0000; font-size:10px; font-weight:normal;">
										<?php
										if($ChangeEmail!="please provide ")
										{
											echo $ChangeEmail;
										}
										?>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									
<br /><input type="submit" name="ChangeEmail" value="Change Email-ID" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" />
								</td>
							</tr>
						</table>
						</form>
						<form name="" action="setting.php" method="post">
						<table align="center" style="font-size:12px; font-weight:bold; color:#666666;">
							<tr>
								<td colspan="2" align="center" style="color:#990000; font-weight:bold; font-size:13px; text-decoration:underline;">
									<br /><br />Change Your Password<br /><br />
								</td>
							</tr>
							<tr>
								<td align="right">
									Old Password:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="password" name="OldPswd" value="" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									New Password:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="password" name="NewPswd" value="" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<span id="SignUpErr" style="color:#FF0000; font-size:10px; font-weight:normal;">
										<?php
											if($ChangePassword!="")
											{
												echo $ChangePassword;
											}
										?>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
<br /><input type="submit" name="ChangePassword" value="Change Password" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" />
								</td>
							</tr>
						</table>
						</form>
						<br /><br />
					<?php
					}
					?>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
	?>
	<script type="text/javascript">
	<?php
	if($ErrUpdateInfo!="please provide your ")
	{
		?>
		alert("<?php echo $ErrUpdateInfo;?>");
		<?php
	}
	if($ErrUpdateContact!="please provide your ")
	{
		?>
		alert("<?php echo $ErrUpdateContact;?>");
		<?php
	}
	if($ChangePassword!="")
	{
		?>
		alert("<?php echo $ChangePassword;?>");
		<?php
	}
	if($ChangeEmail!="please provide ")
	{
		?>
		alert("<?php echo $ChangeEmail;?>");
		<?php
	}
	?>
	</script>
	<?php
?>