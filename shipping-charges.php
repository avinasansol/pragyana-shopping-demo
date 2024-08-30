<?php
	session_start();
	$page="thanks.php";
	include("include/connect-database.php");
	mysql_select_db("shop");
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Shipping Charges</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<img src="img/shipping.jpg" style="max-width:800px;" /><br />
						<br /><br />
						
<table align="center" width="98%" border="0" cellpadding="5" cellspacing="15">
		<?php
		$sql="SELECT MAX(`zone`) FROM `country`";
		$result=mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
			$zone=$row[0];
		}
		for($i=1;$i<=$zone;$i++)
		{
		?>
	<tr align="left" style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
		<td>
			For the following counties:
		</td>
	</tr>
	<tr>
		<td style="text-align:justify;">
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
	</tr>
	<?php 
	$result=mysql_query("SELECT * FROM `shipping` WHERE `zone`='".$i."'");
	while($row=mysql_fetch_array($result))
	{
	?>
	<tr align="left" style="font-weight:bold;">
		<td>
			For shopping price Rs <?php echo $row['from'];?> to Rs <?php echo $row['to'];?>, Shipping Charge = <?php echo $row['shipping'];?>% of Shopping Price
		</td>
	</tr>
	<?php
	}
	?>
		<?php
		}
		?>
	<tr align="left" style="text-transform:uppercase; color:#990000; text-decoration:underline; font-weight:bold;">
		<td>
			For all other counties and shopping prices those are not mentioned above:
		</td>
	</tr>
	<tr align="left" style="font-weight:bold;">
		<td>
			<?php
				$result=mysql_query("SELECT `value` FROM `settings` WHERE `function`='default_shipping'");
				$row=mysql_fetch_array($result);
			?>
			Shipping Charge = <?php echo $row['value'];?>% of Shopping Price
		</td>
	</tr>
</table>
<br /><br />
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
?>