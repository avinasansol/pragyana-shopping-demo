<?php
	session_start();
	$page="page-setup.php";
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
		include("../include/connect-database.php");
		mysql_select_db("shop");
		if(isset($_POST['NoOfProPerPage']))
		{
			if(!preg_match ('/[^a-zA-Z-_`!@#$%^&*()_+}{":?><,.;]/i', $_POST['NoOfProPerPage']))
			{
				$error="Please provide a valid number.";
			}
			else
			{
				mysql_query("UPDATE `settings` SET `value` = '".$_POST['NoOfProPerPage']."' WHERE `settings`.`function` = 'products_per_page'");
			}
		}
		include("admin-files/admin-top.php");
?>
	<h4>Page Setup Settings</h4>
	<form name="ProPerPage" action="page-setup.php" method="post">
		<label style="color:#444444; font-weight:bold;">Select number of maximum products to be shown in a page: </label>
		<select name="NoOfProPerPage">
			<?php
			$NoOfPro=10;
			$result=mysql_query("SELECT `value` FROM `settings` WHERE `function`='products_per_page'");
			if($row=mysql_fetch_array($result))
			{
				$NoOfPro=$row['value'];
			}
			?>
			<option value="<?php echo $NoOfPro;?>"><?php echo $NoOfPro;?></option>
			<?php
				for($i=2;$i<=30;$i=$i+2)
				{
			?>
			<?php if($NoOfPro!=$i){?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php }?>
			<?php
				}
			?>
		</select>
		<?php if($error!=""){echo "<br /><label style='color:#FF0000; font-size:11px;'>".$error."</label><br />";}?>
		<input type="submit" value="DONE" style="margin-top:5px;" />
	</form>
<script type="text/javascript"> 
$(document).ready(function(){
    $("h3").parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").hide("speed");
});
</script>
<?php
		include("admin-files/admin-bottom.php");
	}
?>