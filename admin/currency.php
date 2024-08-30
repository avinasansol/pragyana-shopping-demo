<?php
	session_start();
	$page="currency.php";
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
		$error="";
		if(isset($_POST['CountryID']) && isset($_POST['DefaultCurrency']) && isset($_POST['UpdateDefaultCurrency']) && ($_POST['UpdateDefaultCurrency']=="") && ($_POST['CountryID']!="") && ($_POST['DefaultCurrency']!="") && ($_POST['CountryID']!=null) && ($_POST['DefaultCurrency']!=null))
		{
			if(mysql_query("UPDATE `shop`.`country` SET `country`.`currency` = '".$_POST['DefaultCurrency']."' WHERE `country`.`country_id` = '".$_POST['CountryID']."'"))
			{
				$error="Default Currency has been updated successfully.";
			}
			else
			{
				$error="Default Currency could not be updated due to some error.";
			}
		}
		if(isset($_POST['CurrencyCode']) && isset($_POST['CurrencyValue']) && isset($_POST['UpdateCurrency']) && ($_POST['UpdateCurrency']==""))
		{
			if(($_POST['CurrencyValue']=="") || ($_POST['CurrencyValue']==null))
			{
				$error="Please provide some value of the currency";
			}
			else  if(!preg_match('/^[0-9.]{1,}$/', $_POST['CurrencyValue']))
			{
				$error="The currency value should contain numbers and point only.";
			}
			else if(mysql_query("UPDATE `shop`.`currency` SET `currency`.`value_in_INR` = '".$_POST['CurrencyValue']."' WHERE `currency`.`currency_code` = '".$_POST['CurrencyCode']."'"))
			{
				$error="Currency has been updated successfully.";
			}
			else
			{
				$error="Currency could not be updated due to some error.";
			}
		}
		if(isset($_POST['CurrencyCode']) && isset($_POST['RemoveCurrency']) && ($_POST['RemoveCurrency']==""))
		{
			if(mysql_query("DELETE FROM `shop`.`currency` WHERE `currency`.`currency_code` = '".$_POST['CurrencyCode']."'"))
			{
				mysql_query("UPDATE `shop`.`country` SET `country`.`currency` = 'INR' WHERE `country`.`currency` = '".$_POST['CurrencyCode']."'");
				$error="Currency has been deleted successfully.";
			}
			else
			{
				$error="Currency could not be deleted due to some error.";
			}
		}
		if(isset($_POST['AddCurrency']) && isset($_POST['NewCurrencyName']) && isset($_POST['NewCurrencyCode']) && isset($_POST['NewCurrencyValue']) && ($_POST['AddCurrency']=="Add The Currency"))
		{
			$error="Please provide the new currency's ";
			if(($_POST['NewCurrencyName']=="") || ($_POST['NewCurrencyName']==null))
			{
				$error=$error." name,";
			}
			if(($_POST['NewCurrencyCode']=="") || ($_POST['NewCurrencyCode']==null))
			{
				$error=$error." code,";
			}
			if(($_POST['NewCurrencyValue']=="") || ($_POST['NewCurrencyValue']==null))
			{
				$error=$error." value,";
			}
			if($error!="Please provide the new currency's ")
			{
				$error[(strlen($error)-1)]=".";
			}
			else if(strlen($_POST['NewCurrencyName'])>40)
			{
				$error="The currency name should be less than 40 characters long.";
			}
			else if(strlen($_POST['NewCurrencyCode'])>5)
			{
				$error="The currency name should be less than 5 characters long.";
			}
			else  if(!preg_match('/^[0-9.]{1,}$/', $_POST['NewCurrencyValue']))
			{
				$error="The currency value should contain numbers and point only.";
			}
			else
			{
				$result=mysql_query("SELECT `currency_code` FROM `currency` WHERE `currency_code`='".$_POST['NewCurrencyCode']."'");
				if(mysql_fetch_array($result))
				{
					$error="A currency with currency code ".$_POST['NewCurrencyCode']." already exists.";
				}
				else
				{
					mysql_query("INSERT INTO `shop`.`currency` (`currency_code`, `currency_name`, `value_in_INR`) VALUES ('".$_POST['NewCurrencyCode']."', '".$_POST['NewCurrencyName']."', '".$_POST['NewCurrencyValue']."')");
					$error="The new currency has been added successfully.";
				}
			}
		}
		?>
			<h4>Currency Editer</h4>
			<table align="center" cellpadding="5" cellspacing="5" border="0">
				<tr style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
					<td align="right">
						Currency Name
					</td>
					<td align="center">
						Currency CODE
					</td>
					<td align="center">
						Value In INR
					</td>
					<td align="center">
						Update
					</td>
					<td align="center">
						Delete
					</td>
				</tr>
				<?php
				$sql="SELECT * FROM `currency`";
				$result=mysql_query($sql);
				$temp=0;
				$ItemNo=1;
				while($row=mysql_fetch_array($result))
				{
				?>
				<tr>
				<form action="currency.php" method="post">
					<td align="right" style="color:#444444; font-weight:bold;">
						<?php echo $row['currency_name'];?>:
					</td>
					<td align="center">
						<?php echo $row['currency_code'];?>
						<input type="hidden" name="CurrencyCode" value="<?php echo $row['currency_code'];?>" />
					</td>
					<td align="center">
						<input type="text" name="CurrencyValue" value="<?php echo $row['value_in_INR'];?>" style="width:50px;" />
					</td>
					<td align="center">
						<input type="submit" name="UpdateCurrency" title="Update The Currency" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
					</td>
					<td align="center">
						<input type="submit" name="RemoveCurrency" title="Delete The Currency" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/remove.jpg); background-repeat:no-repeat; cursor:pointer;" />
					</td>
				</form>
				</tr>
				<?php
				}
				?>
			</table><br />
			<form name="AddCurrencyForm" action="currency.php" method="post">
				<label style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Add New Currency</label><br /><br />
				<label style="color:#444444; font-weight:bold;">Currency Name: </label>
				<input type="text" maxlength="40" name="NewCurrencyName" value="<?php if(isset($_POST['NewCurrencyName']) && $error!="The new currency has been added successfully."){echo $_POST['NewCurrencyName'];}?>" /><br /><br />
				<label style="color:#444444; font-weight:bold;">&nbsp;Currency Code: </label>
				<input type="text" maxlength="40" name="NewCurrencyCode" value="<?php if(isset($_POST['NewCurrencyCode']) && $error!="The new currency has been added successfully."){echo $_POST['NewCurrencyCode'];}?>" /><br /><br />
				<label style="color:#444444; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;Value In INR: </label>
				<input type="text" maxlength="40" name="NewCurrencyValue" value="<?php if(isset($_POST['NewCurrencyValue']) && $error!="The new currency has been added successfully."){echo $_POST['NewCurrencyValue'];}?>" /><br />
				<?php
				if($error!="" && $error!="The new currency has been added successfully." && isset($_POST['AddCurrency']))
				{
				?>
				<?php echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."</label><br />";?>
				<?php
				}
				?>
				<br /><input type="submit" name="AddCurrency" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' value="Add The Currency" /><br /><br />
			</form>
			<hr />
			<h4>Default Currency For Countries</h4>
			<?php
			$sql="SELECT `country_id`, `short_name`, `currency` FROM `country`";
			$result=mysql_query($sql);
			$temp=0;
			$ItemNo=1;
			while($row=mysql_fetch_array($result))
			{
				if($temp==0)
				{
				?>
					<table align="center" width="95%" cellpadding="5" cellspacing="5" border="0">
					<tr style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
					<td align="right" width="30%">
						Country
					</td>
					<td align="center" width="15%">
						Currency
					</td>
					<td align="center" width="10%">
						Update
					</td>
					<td align="right" width="35%">
						Country
					</td>
					<td align="center" width="15%">
						Currency
					</td>
					<td align="center" width="10%">
						Update
					</td>
					</tr>
				<?php
					$temp=1;
				}
				if($ItemNo%2)
				{
				?>
					<tr>
				<?php
				}
				?>
				<form name="UpdateDefaultCurrency" action="currency.php" method="post">
					<td align="right" width="30%" style="color:#444444; font-weight:bold;">
						<?php echo $row['short_name'];?>:
						<input type="hidden" name="CountryID" value="<?php echo $row['country_id'];?>" />
					</td>
					<td align="center" width="15%">
						<select name="DefaultCurrency">
							<option value="<?php echo $row['currency'];?>"><?php echo $row['currency'];?></option>
							<?php
							if($row['currency']!="INR")
							{
							?>
							<option value="INR">INR</option>
							<?php
							}
							$sql="SELECT `currency_code` FROM `currency`";
							$rslt=mysql_query($sql);
							while($rw=mysql_fetch_array($rslt))
							{
								if($row['currency']!=$rw['currency_code'])
								{
								?>
								<option value="<?php echo $rw['currency_code'];?>"><?php echo $rw['currency_code'];?></option>
								<?php
								}
							}
							?>
						</select>
					</td>
					<td align="center" width="10%">
						<input type="submit" name="UpdateDefaultCurrency" title="Update The Default Currency" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
					</td>
				</form>
				<?php
				if($ItemNo%2==0)
				{
				?>
					</tr>
				<?php
				}
				$ItemNo++;
			}
			if($temp!=0)
			{
				if($ItemNo%2==0)
				{
					if($ItemNo!=2)
					{
					?>
					<td>
					</td>
					<?php
					}
					?>
					</tr>
					<?php
				}
				?>
				</table><br /><hr />
				<?php
			}
			?>
			<script type="text/javascript"> 
				$(document).ready(function(){
   				 $("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
				});
			</script>
			<?php
		include("admin-files/admin-bottom.php");
	}
	if($error!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $error;?>");
	</script>
	<?php
	}
?>