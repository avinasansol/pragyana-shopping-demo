<?php
	session_start();
	$page="thanks.php";
	include("include/connect-database.php");
	mysql_select_db("shop");
	$Err="";
	if(isset($_POST['Name']) && isset($_POST['EmailID']) && isset($_POST['MsgSub']) && isset($_POST['Msg']))
	{
		$Err="please provide your ";
		if(($_POST['Name']=="")||($_POST['Name']==null))
		{
			$Err=$Err."name, ";
		}
		if(($_POST['EmailID']=="")||($_POST['EmailID']==null))
		{
			$Err=$Err."email id, ";
		}
		if(($_POST['MsgSub']=="")||($_POST['MsgSub']==null))
		{
			$Err=$Err."message subject, ";
		}
		if(($_POST['Msg']=="")||($_POST['Msg']==null))
		{
			$Err=$Err."message, ";
		}
		if($Err!="please provide your ")
		{
			$Err[(strlen($Err)-2)]=".";
		}
		else if(!(preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/', $_POST['EmailID'])))
		{
			$Err="please provide a valid email id.";
		}
		else
		{
			$Err="";
/*		 	$to = "admin@pragyana-soft.com";
			$subject = $_POST['MsgSub'];
			$txt = $_POST['Msg'];	
			$headers = "From: ".$_POST['EmailID'];	
			mail($to,$subject,$txt,$headers);				*/
		}
	}
	include("include/top.php");
?>
<style>
#main-content-mid p {
font-family:Georgia, 'Times New Roman', Times, serif; font-size:16px; padding:30px 40px 0 40px; margin:0; text-align:justify; line-height:22px;
}
#main-content-mid p b {
color:#6a8516;
}
</style>
					<div id="main-content-top">
						<h4>Contact Us</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
					<p style="background-image:url(img/pp.jpg); background-repeat:no-repeat; background-position:right top; margin:0px; height:145px; padding:0;">
						<br /><br />
						<label style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:20px; padding-left:40px;">
						Pragyana Shopping Demo<br />
						</label>
						<label style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:20px; padding-left:40px;">
						by Pragyana Softwares<br />
						</label>
						<label style="color:#6a8516; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px; padding-left:40px;">
						An excellence in web developement.....!!!!<br />
						</label>
					</p>
					<hr style="margin:0;" />
					<table align="center">
						<tr>
							<td>
						<p style="color:#990000; font-weight:bold;">
							Our Postal Address:
						</p>
						<p style="padding-top:10px; padding-left:70px;">
							Pragyana Softwares,<br />
							D 3/8, 10th Road,<br />
							Newtown,<br />
							Asansol - 26,<br />
							West Bengal,<br />
							India
						</p>
							</td>
							<td>
						<p style="color:#990000; font-weight:bold;">
							Call Us At:
						</p>
						<p style="padding-top:10px;">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							+91 8101993399<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							+91 34123357540
						</p>
						<p style="color:#990000; font-weight:bold;">
							Mail Us At:
						</p>
						<p style="padding-top:10px;">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							admin@pragyana-soft.com
						</p>
							</td>
						</tr>
					</table>
						<p style="color:#990000; font-weight:bold; text-align:center;">
							Send Us A Message:
						</p>
					<form name="contactform"  method="post" action="contact-us.php">
<table align="center" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:16px;" cellpadding="5" cellspacing="5">
	<tr>
		<td align="right" width="45%">
			Enter your Name: 
		</td>
		<td align="left" width="55%">
			<input type="text" name="Name" value="<?php if(isset($_POST['Name'])){echo $_POST['Name'];}?>" size="36" maxlength="160" style="border:1px solid gray; border-radius:5px;" /><br />
		</td>
	</tr>
	<tr>
		<td align="right">
			E-mail address: 
		</td>
		<td align="left">
			<input type="text" name="EmailID" value="<?php if(isset($_POST['EmailID'])){echo $_POST['EmailID'];}?>" size="36" maxlength="160" style="border:1px solid gray; border-radius:5px;" /><br />
		</td>
	</tr>
	<tr>
		<td align="right">
			Message Subject: 
		</td>
		<td align="left">
			<input type="text" name="MsgSub" value="<?php if(isset($_POST['MsgSub'])){echo $_POST['MsgSub'];}?>" size="36" maxlength="160" style="border:1px solid gray; border-radius:5px;" /><br />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Enter your Message:
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<textarea cols="50" rows="5" name="Msg" value="<?php if(isset($_POST['Msg'])){echo $_POST['Msg'];}?>" style="border:1px solid gray; max-width:700px; min-width:700px; max-height:70px; min-height:70px; border-radius:5px;background-color:#FFFFCC;"> </textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="color:#FF0000; font-size:11px;">
			<?php if($Err!=""){echo $Err;}?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="SEND MESSAGE" name="send" style="border:#666666 solid 1px; border-radius:3px; height:25px;background-image:url(img/product-bg1.png); background-repeat:no-repeat;background-position:bottom left; width:200px;" />
		</td>
	</tr>
</table>
					</form>
						<br /><br /><br /><br />
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
	if($Err!="")
	{
		?>
		<script type="text/javascript">
			alert("<?php echo $Err?>");
		</script>
		<?php
	}
?>