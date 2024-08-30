<?php
	session_start();
	$page="thanks.php";
	if(!isset($_SESSION['LogdUsrDet']))
	{
		header("Location: index.php");
	}
	include("include/connect-database.php");
	mysql_select_db("shop");
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Thank You</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
						<label style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:16px;">
						Congratulations.....!!!<br />
						You have successfully placed your orders.<br />
						Thanks for shopping with us.<br />
						</label>
						<img src="img/success.jpg" style="max-width:500px;" /><br />
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
?>