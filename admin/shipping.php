<?php
	session_start();
	$page="shipping.php";
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
		<h4>Shipping Editer</h4>
<?php
$error="";
$UpError="";
$alert="";
if((isset($_POST['SlNo'])) && (isset($_POST['Zone'])) && (isset($_POST['From'])) && (isset($_POST['To'])) && (isset($_POST['Shipping'])) && (isset($_POST['UpdtSlab'])) && ($_POST['SlNo']!="") && ($_POST['Zone']!="") && ($_POST['Shipping']!="") && ($_POST['UpdtSlab']=="") && ($_POST['SlNo']!=null) && ($_POST['Zone']!=null) && ($_POST['Shipping']!=null))
{
	$UpSlNo=$_POST['SlNo'];
	if(($_POST['From']=="") || ($_POST['To']=="") || ($_POST['From']==null) || ($_POST['To']==null))
	{
		$UpError="Please provide the complete price slab including from and to price.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['SlNo']))
	{
		$UpError="The slab could not be updated as the serial no. was invalid.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['Zone']))
	{
		$UpError="The slab could not be updated as the zone was invalid.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['From']))
	{
		$UpError="The slab could not be updated as the from price was not a valid number.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['To']))
	{
		$UpError="The slab could not be updated as the to price was not a valid number.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['Shipping']))
	{
		$UpError="The slab could not be updated as the shipping percentage was invalid.";
	}
	else if(((int) $_POST['From']) > ((int) $_POST['To']))
	{
		$UpError="The slab could not be updated as the `from` price was greater than `to` price.";
	}
	else
	{
		$result=mysql_query("SELECT `slno` FROM `shipping` WHERE `zone` ='".$_POST['Zone']."' AND `slno`!='".$_POST['SlNo']."' AND ((`from` BETWEEN ".$_POST['From']." AND ".$_POST['To'].") OR (`to` BETWEEN ".$_POST['From']." AND ".$_POST['To']."))");
		if(mysql_fetch_array($result))
		{
			$UpError="The slab could not be updated as an already existing slab for zone ".$_POST['Zone']." contains some values provided for 'from' and 'to' price.";
		}
		else
		{
			$check=0;
			$result=mysql_query("SELECT `from`, `to` FROM `shipping` WHERE `zone` ='".$_POST['Zone']."' AND `slno`!='".$_POST['SlNo']."'");
			while($row=mysql_fetch_array($result))
			{
				if( (($row['from']<((int) $_POST['From'])) && ($row['to']>((int) $_POST['From']))) || (($row['from']>((int) $_POST['To'])) && ($row['to']<((int) $_POST['To']))) )
				{
					$UpError="The slab could not be updated as an already existing slab for zone ".$_POST['Zone']." contains some values provided for 'from' and 'to' price.";
					$check=1;
					break;
				}
			}
			if($check==0)
			{
				mysql_query("UPDATE `shop`.`shipping` SET `from`='".$_POST['From']."', `to`='".$_POST['To']."', `shipping`='".$_POST['Shipping']."' WHERE `zone`='".$_POST['Zone']."' AND  `slno`='".$_POST['SlNo']."'");
				$alert="The slab has been updated successfully.";
			}
		}
	}
}
if((isset($_POST['SlabZone'])) && (isset($_POST['SlabFrom'])) && (isset($_POST['SlabTo'])) && (isset($_POST['SlabShipping'])) && (isset($_POST['AddSlab'])) && ($_POST['SlabZone']!="") && ($_POST['SlabShipping']!="") && ($_POST['AddSlab']=="Add The Slab") && ($_POST['SlabZone']!=null) && ($_POST['SlabShipping']!=null))
{
	if(($_POST['SlabFrom']=="") || ($_POST['SlabTo']=="") || ($_POST['SlabFrom']==null) || ($_POST['SlabTo']==null))
	{
		$error="Please provide the complete price slab including from and to price.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['SlabZone']))
	{
		$error="The new slab could not be added as the zone is invalid.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['SlabFrom']))
	{
		$error="The new slab could not be added as the from price is not a valid number.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['SlabTo']))
	{
		$error="The new slab could not be added as the to price is not a valid number.";
	}
	else if(!preg_match('/^[0-9]{1,}$/', $_POST['SlabShipping']))
	{
		$error="The new slab could not be added as the shipping percentage is invalid.";
	}
	else if(((int) $_POST['SlabFrom']) > ((int) $_POST['SlabTo']))
	{
		$error="The new slab could not be added as the `from` price is greater than `to` price.";
	}
	else
	{
		$result=mysql_query("SELECT `slno` FROM `shipping` WHERE `zone` ='".$_POST['SlabZone']."' AND ((`from` BETWEEN ".$_POST['SlabFrom']." AND ".$_POST['SlabTo'].") OR (`to` BETWEEN ".$_POST['SlabFrom']." AND ".$_POST['SlabTo']."))");
		if(mysql_fetch_array($result))
		{
			$error="The new slab could not be added as an already existing slab for zone ".$_POST['SlabZone']." contains some value provided of 'from' and 'to' price.";
		}
		else
		{
			$check=0;
			$result=mysql_query("SELECT `from`, `to` FROM `shipping` WHERE `zone` ='".$_POST['SlabZone']."'");
			while($row=mysql_fetch_array($result))
			{
				if( (($row['from']<((int) $_POST['SlabFrom'])) && ($row['to']>((int) $_POST['SlabFrom']))) || (($row['from']>((int) $_POST['SlabTo'])) && ($row['to']<((int) $_POST['SlabTo']))) )
				{
					$error="The new slab could not be added as an already existing slab for zone ".$_POST['SlabZone']." contains some value provided of 'from' and 'to' price.";
					$check=1;
					break;
				}
			}
			if($check==0)
			{
				mysql_query("INSERT INTO `shop`.`shipping` (`slno`, `zone`, `from`, `to`, `shipping`) VALUES (NULL, '".$_POST['SlabZone']."', '".$_POST['SlabFrom']."', '".$_POST['SlabTo']."', '".$_POST['SlabShipping']."')");
				$alert="The new slab has been added successfully.";
			}
		}
	}
}
if(isset($_POST['DltSlab']) && $_POST['DltSlab']=="" && (isset($_POST['SlNo'])) && ($_POST['SlNo']!="") && ($_POST['SlNo']!=null))
{
	mysql_query("DELETE from `shop`.`shipping` WHERE `slno`='".$_POST['SlNo']."'");
	$alert="The slab has been deleted successfully.";
}
if(isset($_POST['DefaultShippingEdit']) && $_POST['DefaultShippingEdit']=="" && isset($_POST['Shipping']))
{
	mysql_query("UPDATE `shop`.`settings` SET `value`='".$_POST['Shipping']."' WHERE `function`='default_shipping'");
	$alert="Default shipping percentage is now set to ".$_POST['Shipping'];
}
if(isset($_POST['AddCountriesToNewZone']) && $_POST['AddCountriesToNewZone']=="ADD SELECTED COUNTRIES")
{
	$sql="SELECT MAX(`zone`) FROM `country`";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
	{
		$zone=$row[0];
	}
	$zone++;
	$sql="SELECT `iso2` FROM `country` WHERE `zone`='0'";
	$result=mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
		if(isset($_POST[$row['iso2']]))
		{
			mysql_query("UPDATE `country` SET `zone`='".$zone."' WHERE `iso2`='".$row['iso2']."'");
			$i++;
		}
	}
	if($i==0)
	{
		$alert="New zone could not be added as no countries were added to it.";
	}
	else
	{
		$alert=$i." countries have been successfully added to the new zone.";
	}
}
if(isset($_POST['AddCountries']) && $_POST['AddCountries']=="ADD SELECTED COUNTRIES" && isset($_POST['Zone']))
{
	$zone=(int) $_POST['Zone'];
	$sql="SELECT `iso2` FROM `country` WHERE `zone`='0'";
	$result=mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
		if(isset($_POST[$row['iso2']]))
		{
			mysql_query("UPDATE `country` SET `zone`='".$zone."' WHERE `iso2`='".$row['iso2']."'");
			$i++;
		}
	}
	if($i==0)
	{
		$alert="No coutries were selected.";
	}
	else
	{
		$alert=$i." countries have been successfully added to zone ".$_POST['Zone'].".";
	}
}
if(isset($_POST['DelCountries']) && $_POST['DelCountries']=="REMOVE SELECTED COUNTRIES" && isset($_POST['Zone']))
{
	$zone=(int) $_POST['Zone'];
	$sql="SELECT `iso2` FROM `country` WHERE `zone`='".$zone."'";
	$result=mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
		if(isset($_POST[$row['iso2']]))
		{
			mysql_query("UPDATE `country` SET `zone`='0' WHERE `iso2`='".$row['iso2']."'");
			$i++;
		}
	}
	if($i==0)
	{
		$alert="No coutries were selected.";
	}
	else
	{
		$alert=$i." countries have been successfully removed from zone ".$_POST['Zone'].".";
	}
}
if(isset($_POST['AddZone']) && $_POST['AddZone']=="Add Zone")
{
	$sql="SELECT MAX(`zone`) FROM `country`";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
	{
		$zone=$row[0];
	}
?>
<hr /><br />
<label style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Adding New Zone: Zone <?php echo $zone+1;?></label><br /><br />
<form name="ProPerPage" action="shipping.php" method="post">
	<label style="color:#444444; font-weight:bold;">Select countries to be added to Zone <?php echo $zone+1;?>: </label><br /><br />
	<table align="center">
	<?php
	$sql="SELECT `short_name`, `iso2` FROM `country` WHERE `zone`='0'";
	$result=mysql_query($sql);
	$ItemNo=1;
	while($row=mysql_fetch_array($result))
	{
		if($ItemNo%2)
		{
		?>
			<tr>
		<?php
		}
		?>
		<td width="15%" align="right">
			<input type="checkbox" name="<?php echo $row['iso2'];?>" />
		</td>
		<td width="35%" align="left">
			<?php echo $row['short_name'];?>
		</td>
		<?php
		if($ItemNo%2==0)
		{
		?>
			</tr>
		<?php
		}
		$ItemNo++;
	}
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
	</table><br />
	<input type="submit" name="AddCountriesToNewZone" value="ADD SELECTED COUNTRIES" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' />
</form>
<br /><br /><hr />
<?php
}
if(isset($_POST['EditZone']) && isset($_POST['Zone']) && $_POST['EditZone']=="Edit Zone")
{
?>
<hr /><br />
<label style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Editing Zone <?php echo $_POST['Zone'];?></label><br /><br />
	<?php
	$sql="SELECT `short_name`, `iso2` FROM `country` WHERE `zone`='".$_POST['Zone']."'";
	$result=mysql_query($sql);
	$temp=0;
	$ItemNo=1;
	while($row=mysql_fetch_array($result))
	{
		if($temp==0)
		{
		?>
		<form name="ProPerPage" action="shipping.php" method="post">
			<input type="hidden" name="Zone" value="<?php echo $_POST['Zone'];?>" />
			<label style="color:#444444; font-weight:bold;">Select countries to be removed from Zone <?php echo $_POST['Zone'];?>: </label><br /><br />
			<table align="center" width="90%">
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
		<td width="5%" align="right">
			<input type="checkbox" name="<?php echo $row['iso2'];?>" />
		</td>
		<td width="45%" align="left">
			<?php echo $row['short_name'];?>
		</td>
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
	</table><br />
	<input type="submit" name="DelCountries" value="REMOVE SELECTED COUNTRIES" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' />
</form>
<br /><br />
	<?php
	}
	$sql="SELECT `short_name`, `iso2` FROM `country` WHERE `zone`='0'";
	$result=mysql_query($sql);
	$temp=0;
	$ItemNo=1;
	while($row=mysql_fetch_array($result))
	{
		if($temp==0)
		{
		?>
		<form name="ProPerPage" action="shipping.php" method="post">
			<input type="hidden" name="Zone" value="<?php echo $_POST['Zone'];?>" />
			<label style="color:#444444; font-weight:bold;">Select countries to be added to Zone <?php echo $_POST['Zone'];?>: </label><br /><br />
			<table align="center" width="90%">
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
		<td width="5%" align="right">
			<input type="checkbox" name="<?php echo $row['iso2'];?>" />
		</td>
		<td width="45%" align="left">
			<?php echo $row['short_name'];?>
		</td>
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
	</table><br />
		<input type="submit" name="AddCountries" value="ADD SELECTED COUNTRIES" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' />
	</form>
	<br /><br />
	<?php
	}
	?>
<hr />
<?php
}
if((!isset($_POST['AddZone']))&&(!((isset($_POST['EditZone']))&&(isset($_POST['Zone'])))))
{
?>
<table align="center" width="98%" border="0" cellpadding="5" cellspacing="15">
	<tr style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
		<td width="10%">
			Zone
		</td>
		<td>
			Price Slab
		</td>
		<td width="15%">
			Shipping %
		</td>
		<td width="15%">
			Update
		</td>
		<td width="15%">
			Delete
		</td>
	</tr>
	<?php 
	$result=mysql_query("SELECT * FROM `shipping` ORDER BY `zone`");
	while($row=mysql_fetch_array($result))
	{
	?>
	<tr>
	<form action="shipping.php" method="post">
			<input type="hidden" name="SlNo" value="<?php echo $row['slno'];?>" />
			<input type="hidden" name="Zone" value="<?php echo $row['zone'];?>" />
		<td width="10%">
			<?php echo $row['zone'];?>
		</td>
		<td>
			<input type="text" name="From" value="<?php echo $row['from'];?>" style="width:70px;" /> INR to 
			<input type="text" name="To" value="<?php echo $row['to'];?>" style="width:70px;" /> INR
		</td>
		<td width="15%">
			<select name="Shipping">
				<option value="<?php echo $row['shipping'];?>"><?php echo $row['shipping'];?>%</option>
				<?php
				for($i=0;$i<=60;$i++)
				{
					if($i!=$row['shipping'])
					{
					?>
						<option value="<?php echo $i;?>"><?php echo $i;?>%</option>
					<?
					}
				}
				?>
			</select>
		</td>
		<td width="15%">
			<input type="submit" name="UpdtSlab" title="Update The Slab" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
		</td>
	</form>
		<td width="15%">
		<form action="shipping.php" onsubmit="return ValidateDelete()" method="post">
			<input type="hidden" name="SlNo" value="<?php echo $row['slno'];?>" />
			<input type="submit" name="DltSlab" title="Delete The Slab" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/remove.jpg); background-repeat:no-repeat; cursor:pointer;" />
		</form>
		</td>
	</tr>
	<?php
	if($UpError!="" && $UpSlNo==$row['slno'])
	{
	?>
	<tr>
		<td colspan="5">
			<label style='color:#FF0000; font-size:11px;'><?php echo $UpError;?></label><br />
		</td>
	</tr>
	<?php
	}
	?>
	<?php
	}
	?>
	<form action="shipping.php" method="post">
	<tr>
		<td width="10%">
			all
		</td>
		<td>
			Default
		</td>
		<td width="15%">
			<select name="Shipping">
				<?php 
				$result=mysql_query("SELECT `value` FROM `settings` WHERE `function`='default_shipping'");
				if($row=mysql_fetch_array($result))
				{
					$default=(int)$row['value'];
				}
				?>
				<option value="<?php echo $default;?>"><?php echo $default;?>%</option>
				<?php
				for($i=0;$i<=60;$i++)
				{
					if($i!=$default)
					{
					?>
						<option value="<?php echo $i;?>"><?php echo $i;?>%</option>
					<?
					}
				}
				?>
			</select>
		</td>
		<td width="15%">
			<input type="submit" name="DefaultShippingEdit" title="Update The Slab" value="" style="border:0; background-color:#FFFFFF; background-image:url(../img/update.png); background-repeat:no-repeat; cursor:pointer;" />
		</td>
		<td width="15%">
		</td>
	</tr>
	</form>
</table>
<br />
<form action="shipping.php" method="post">
	<label style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Add A New Slab:</label><br /><br />
	<label style="color:#444444; font-weight:bold;">Zone: </label>
	<select name="SlabZone">
	<?php if(isset($_POST['SlabZone']) && $alert!="The new slab has been added successfully.")
	{
	?>
	<option value="<?php echo $_POST['SlabZone'];?>"><?php echo $_POST['SlabZone'];?></option>
	<?php 
	}
	for($i=1;$i<=5;$i++)
	{
	?>
		<option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php
	}
	?>
	</select><br /><br />
	<label style="color:#444444; font-weight:bold;">Price Slab: </label>
	from <input type="text" name="SlabFrom" value="<?php if(isset($_POST['SlabFrom']) && $alert!="The new slab has been added successfully."){echo $_POST['SlabFrom'];}?>" style="width:60px;" /> INR
	to <input type="text" name="SlabTo" value="<?php if(isset($_POST['SlabTo']) && $alert!="The new slab has been added successfully."){echo $_POST['SlabTo'];}?>" style="width:60px;" /> INR<br /><br />
	<label style="color:#444444; font-weight:bold;">Shipping Percentage: </label>
	<select name="SlabShipping">
	<?php if(isset($_POST['SlabShipping']) && $alert!="The new slab has been added successfully.")
	{
	?>
	<option value="<?php echo $_POST['SlabShipping'];?>"><?php echo $_POST['SlabShipping'];?></option>
	<?php 
	}
	for($i=0;$i<=60;$i++)
	{
	?>
		<option value="<?php echo $i;?>"><?php echo $i;?>%</option>
	<?php
	}
	?>
	</select><br />
	<?php
	if($error!="")
	{
	?>
	<?php echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."</label><br />";?>
	<?php
	}
	?><br />
	<input type="submit" name="AddSlab" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' value="Add The Slab" />
</form>
<br />
<hr />
<h4>Shipping Zone Editer</h4>
<table align="center" width="98%" border="0" cellpadding="5" cellspacing="15">
	<tr style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
		<td width="10%">
			Zone
		</td>
		<td>
			Countries
		</td>
		<td width="15%">
		</td>
	</tr>
		<?php
		$sql="SELECT MAX(`zone`) FROM `country`";
		$result=mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
			$zone=$row[0];
		}
		for($i=0;$i<=$zone;$i++)
		{
		?>
	<tr>
		<td width="15%">
			<?php if($i==0){echo "Default Zone";}else{echo "Zone ".$i;}?>
		</td>
		<td style="text-align:justify;"<?php if($i==0){?> colspan="2"<?php }?>>
			<?php
			$sql="SELECT `short_name` FROM `country` WHERE `zone`='".$i."'";
			$result=mysql_query($sql);
			$print="";
			while($row=mysql_fetch_array($result))
			{
				$print=$print.$row['short_name'].", ";
			}
			if($print=="")
			{
				echo "NO COUNTRY";
			}
			else
			{
				$print[(strlen($print))-2]=".";
				echo $print;
			}
			?>
		</td>
		<?php if($i!=0){?>
		<td width="15%">
			<form action="shipping.php" method="post">
				<input type="hidden" name="Zone" value="<?php echo $i;?>" />
				<input type="submit" name="EditZone" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' value="Edit Zone" />
			</form>
		</td>
		<?php }?>
	</tr>
		<?php
		}
		?>
</table>
<?php
if($print!="")
{
?>
<br />
<form action="shipping.php" method="post">
<label style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">Add New Zone:</label>&nbsp;&nbsp; Zone <?php echo $zone+1;?> &nbsp;&nbsp;&nbsp;
<input type="submit" name="AddZone" style='border:#666666 solid 1px; border-radius:5px; padding:4px 10px 4px 10px; background-image:url(../img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left; cursor:pointer;' value="Add Zone" />
</form>
<br />
<?php
}
?>
<br /><br />
<hr />
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
	if($alert!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $alert;?>");
	</script>
	<?php
	}
	if($error!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $error;?>");
	</script>
	<?php
	}
	if($UpError!="")
	{
	?>
	<script type="text/javascript">
		alert("<?php echo $UpError;?>");
	</script>
	<?php
	}
?>