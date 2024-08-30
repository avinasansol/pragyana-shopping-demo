<?php
	$con = mysql_connect("localhost","root","asansol");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
?>