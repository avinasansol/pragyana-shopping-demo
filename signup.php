<?php
	session_start();
	$page="signup.php";
	if(isset($_SESSION['LogdUsrDet']))
	{
		header("Location: index.php");
	}
	$Err="please provide your ";
	if(isset($_POST['FormName']))
	{
		if((!isset($_POST['FirstName']))||($_POST['FirstName']=="")||($_POST['FirstName']==null))
		{
			$Err=$Err."first name, ";
		}
		if((!isset($_POST['LastName']))||($_POST['LastName']=="")||($_POST['LastName']==null))
		{
			$Err=$Err."last name, ";
		}
		if((!isset($_POST['Gender']))||($_POST['Gender']=="")||($_POST['Gender']==null))
		{
			$Err=$Err."gender, ";
		}
		if((!isset($_POST['DateBirth']))||($_POST['DateBirth']=="")||($_POST['DateBirth']==null))
		{
			$Err=$Err."birth date, ";
		}
		if((!isset($_POST['MonthBirth']))||($_POST['MonthBirth']=="")||($_POST['MonthBirth']==null))
		{
			$Err=$Err."birth month, ";
		}
		if((!isset($_POST['YearBirth']))||($_POST['YearBirth']=="")||($_POST['YearBirth']==null))
		{
			$Err=$Err."birth year, ";
		}
		if((!isset($_POST['Email']))||($_POST['Email']=="")||($_POST['Email']==null))
		{
			$Err=$Err."email, ";
		}
		if((!isset($_POST['ConEmail']))||($_POST['ConEmail']=="")||($_POST['ConEmail']==null))
		{
			$Err=$Err."confirm email, ";
		}
		if((!isset($_POST['Org']))||($_POST['Org']=="")||($_POST['Org']==null))
		{
			$Err=$Err."organization, ";
		}
		if((!isset($_POST['StreetAdd']))||($_POST['StreetAdd']=="")||($_POST['StreetAdd']==null))
		{
			$Err=$Err."street address, ";
		}
		if((!isset($_POST['PostCode']))||($_POST['PostCode']=="")||($_POST['PostCode']==null))
		{
			$Err=$Err."postal code, ";
		}
		if((!isset($_POST['City']))||($_POST['City']=="")||($_POST['City']==null))
		{
			$Err=$Err."city, ";
		}
		if((!isset($_POST['State']))||($_POST['State']=="")||($_POST['State']==null))
		{
			$Err=$Err."state, ";
		}
		if((!isset($_POST['Country']))||($_POST['Country']=="")||($_POST['Country']==null))
		{
			$Err=$Err."country, ";
		}
		if((!isset($_POST['PhNo']))||($_POST['PhNo']=="")||($_POST['PhNo']==null))
		{
			$Err=$Err."phone number, ";
		}
		if($Err!="please provide your ")
		{
			$Err[(strlen($Err)-2)]=".";
		}
		else if(!(preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/', $_POST['Email'])))
		{
			$Err="please provide a valid email id.";
		}
		else if(!preg_match('/^[0-9]{1,}$/', $_POST['PhNo']))
		{
			$Err="please provide a valid phone number.";
		}
		else if($_POST['Email']!=$_POST['ConEmail'])
		{
			$Err="confirm email id doesn't match with email id.";
		}
		else
		{
			include("include/connect-database.php");
			mysql_select_db("shop");		
			$result=mysql_query("SELECT `iso2` FROM `country` WHERE `iso2`='".$_POST['Country']."'");
			$cntry=0;
			while($row=mysql_fetch_array($result))
			{
				if($row['iso2']==$_POST['Country'])
				{
					$cntry=1;
					$sql="SELECT `username` FROM `user` WHERE `username` = '".$_POST['Email']."'";
					$res=mysql_query($sql);
					break;
				}
			}
			if($cntry==0)
			{
				$Err="The country you provided is not valid.";
			}
			else if($rw=mysql_fetch_array($res))
			{
				$Err="The email id '".$_POST['Email']."' is not available.";
			}
			else
			{
				$sql="SELECT `username` FROM `admin` WHERE `username` = '".$_POST['Email']."'";
				$res=mysql_query($sql);
				if($rw=mysql_fetch_array($res))
				{
					$Err="The email id '".$_POST['Email']."' is not available.";
				}
				else
				{
					function gen_pass($len = 8)
					{
					    return substr(md5(rand().rand()), 0, $len);
					}
					$pass=gen_pass();
					$sql="INSERT INTO `shop`.`user` ( `username` , `password` , `name` , `last_name` , `gender` , `dob` , `org` , `add` , `pin_code` , `city` , `state` , `country` , `phno`, `date`, `last_login`  ) VALUES ( '".$_POST['Email']."', '".$pass."', '".$_POST['FirstName']."', '".$_POST['LastName']."', '".$_POST['Gender']."', '".$_POST['YearBirth']."-".$_POST['MonthBirth']."-".$_POST['DateBirth']."', '".$_POST['Org']."', '".$_POST['StreetAdd']."', '".$_POST['PostCode']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Country']."', '".$_POST['PhNo']."', CURDATE(), CURDATE())";
					mysql_query($sql);
					$sql="CREATE TABLE `cart_".$_POST['Email']."` ( `product` varchar( 15 ) NOT NULL , `quantity` int( 15 ) NOT NULL DEFAULT '1', `date` DATE NOT NULL, PRIMARY KEY ( `product` )  ) ENGINE = InnoDB DEFAULT CHARSET = latin1";
					mysql_query($sql);
					$sql="CREATE TABLE `order_".$_POST['Email']."` ( `order_id`	int(9), `product` varchar( 15 ) NOT NULL , `quantity` int( 15 ) NOT NULL DEFAULT '1', `price` int( 15 ) NOT NULL ) ENGINE = InnoDB DEFAULT CHARSET = latin1";
					mysql_query($sql);
/*		
		 			$to = $_POST['Email'];
			 		$subject = "Registration @ xyzimaginary.com";
			 		$txt = "Hi ".$_POST['FirstName']."..... \n\nWe are glad to inform you that you have been added to the users list of xyzimaginary.com. We would like to invite you to login and buy our beautiful products at afordable prices.\n\nYour email id ".$_POST['Email']." will serve as your username and your initial password is ".$pass."\n\nYou can change your password after loging in.\n\nBest Wishes,\nxyzimaginary.com";
			 		$headers = "From: admin@xyzimaginary.com";	
					mail($to,$subject,$txt,$headers);
*/
					header("Location: index.php?Email=".$_POST['Email']);
				}
			}
		}
	}
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Please Provide Informations Below to Sign Up</h4>						
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<form name="SignUpForm" action="signup.php" method="post">
						<input type="hidden" name="FormName" value="SignUpForm" />
						<table align="center" style="font-size:12px; font-weight:bold; color:#666666;">
							<tr>
								<td colspan="2" align="center" style="color:#990000; font-weight:bold; font-size:13px; text-decoration:underline;">
									<br />Your Personal Details<br /><br />
								</td>
							</tr>
							<tr>
								<td align="right">
									First Name: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="FirstName" value="<?php if(isset($_POST['FirstName'])){echo $_POST['FirstName'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Last Name: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="LastName" value="<?php if(isset($_POST['LastName'])){echo $_POST['LastName'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Gender:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<select name="Gender" style="border:#666666 solid 1px; border-radius:3px;">
										<option value="<?php if((isset($_POST['Gender']))&&($_POST['Gender']!="")){echo $_POST['Gender'];}?>"><?php if((isset($_POST['Gender']))&&($_POST['Gender']!="")){echo $_POST['Gender'];}else{echo "select your gender";}?></option>
										<?php if(!((isset($_POST['Gender']))&&($_POST['Gender']=="Male"))){?><option value="Male">Male</option><?php }?>
										<?php if(!((isset($_POST['Gender']))&&($_POST['Gender']=="Female"))){?><option value="Female">Female</option><?php }?>
									</select>
								</td>
							</tr>
							<tr>
								<td align="right">
									Date of Birth: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<select name="DateBirth" style="border:#666666 solid 1px; border-radius:3px;">
										<option value="<?php if(isset($_POST['DateBirth'])){echo $_POST['DateBirth'];}?>"><?php if(isset($_POST['DateBirth'])&&($_POST['DateBirth']!="")){echo $_POST['DateBirth'];}else{echo "Date";}?></option>
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
										<option value="<?php if(isset($_POST['MonthBirth'])){echo $_POST['MonthBirth'];}?>"><?php if(isset($_POST['MonthBirth'])&&($_POST['MonthBirth']!="")){echo $_POST['MonthBirth'];}else{echo "Month";}?></option>
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
										<option value="<?php if(isset($_POST['YearBirth'])){echo $_POST['YearBirth'];}?>"><?php if(isset($_POST['YearBirth'])&&($_POST['YearBirth']!="")){echo $_POST['YearBirth'];}else{echo "Year";}?></option>
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
								<td align="right">
									E-Mail:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="Email" value="<?php if(isset($_POST['Email'])){echo $_POST['Email'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Confirm E-Mail:	<b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="ConEmail" value="<?php if(isset($_POST['ConEmail'])){echo $_POST['ConEmail'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Company/Organization: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="Org" value="<?php if(isset($_POST['Org'])){echo $_POST['Org'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="color:#990000; font-weight:bold; font-size:13px; text-decoration:underline;">
									<br />Your Contact Informations<br /><br />
								</td>
							</tr>
							<tr>
								<td align="right">
									Street Address: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="StreetAdd" value="<?php if(isset($_POST['StreetAdd'])){echo $_POST['StreetAdd'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Postal Code: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="PostCode" value="<?php if(isset($_POST['PostCode'])){echo $_POST['PostCode'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									City: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="City" value="<?php if(isset($_POST['City'])){echo $_POST['City'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									State/Province: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<input type="text" name="State" value="<?php if(isset($_POST['State'])){echo $_POST['State'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td align="right">
									Country: <b style="color:#FF0000; font-size:10px; font-weight:normal;">*</b>
								</td>
								<td align="left">
									<select name="Country" style="border:#666666 solid 1px;width:170px;border-radius:3px;">
										<option value="<?php if(isset($_POST['Country'])){echo $_POST['Country'];}?>"><?php if(isset($_POST['Country'])&&($_POST['Country']!="")){
										include("include/connect-database.php");
										mysql_select_db("shop");
										$result=mysql_query("SELECT `short_name` FROM `country` WHERE `iso2`='".$_POST['Country']."'");
										if($row=mysql_fetch_array($result))
										{echo $row['short_name'];}}else{echo "select your country";}?></option>
										<?php
										include("include/connect-database.php");
										mysql_select_db("shop");
										$result=mysql_query("SELECT `iso2`, `short_name` FROM `country`");
										while($row=mysql_fetch_array($result))
										{
										?>
											<option value="<?php echo $row['iso2'];?>"><?php echo $row['short_name'];?></option>
										<?php
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
									<input type="text" name="PhNo" value="<?php if(isset($_POST['PhNo'])){echo $_POST['PhNo'];}?>" style="border:#666666 solid 1px; border-radius:3px; width:170px; height:17px;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<span id="SignUpErr" style="color:#FF0000; font-size:10px; font-weight:normal;">
										<?php
											if($Err!="please provide your ")
											{
												echo $Err;
											}
										?>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="Sign Up" style="border:#666666 solid 1px; border-radius:3px; width:70px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left;" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="font-weight:normal; color:#000000; font-family:Georgia, 'Times New Roman', Times, serif;">
									An auto generated password will be mailed to you. <br />
									Further, you can change your password once you login. <br /><br />
								</td>
							</tr>
						</table>
						</form>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
	if($Err!="please provide your ")
	{
		?>
		<script type="text/javascript">
			alert("<?php echo $Err?>");
		</script>
		<?php
	}
?>