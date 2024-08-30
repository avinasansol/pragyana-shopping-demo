<?php
	session_start();
	$page="email.php";
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
		<h4>Service Not Available</h4>
<?php
		include("admin-files/admin-bottom.php");
	}
?>
<script type="text/javascript">
	alert("You can not access this service. Please contact your software provider.");
</script>