<?php
	session_start();
	if(isset($_SESSION['LogdUsrDet']))
	{
		unset($_SESSION['YourCart']);
		unset($_SESSION['YourCartPrice']);
		unset($_SESSION['LogdUsrDet']);
		session_destroy();
	}
	header("Location: index.php");
?>