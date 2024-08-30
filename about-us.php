<?php
	session_start();
	$page="thanks.php";
	include("include/connect-database.php");
	mysql_select_db("shop");
	include("include/top.php");
?>
<style>
#main-content-mid p {
font-family:Georgia, 'Times New Roman', Times, serif; font-size:16px; padding:30px 40px 0 40px; margin:0; text-align:justify; line-height:22px;
}
#main-content-mid p a {
text-decoration:none; color:#6a8516; font-weight:bold;
}
#main-content-mid p a:hover {
text-decoration:underline; color:#990000;
}
#main-content-mid p b {
color:#6a8516;
}
</style>
					<div id="main-content-top">
						<h4>About Us</h4>
					</div>
					<div id="main-content-mid">
					<p style="background-image:url(img/pp.jpg); background-repeat:no-repeat; background-position:right top; margin:0px; height:145px; padding:0;">
						<br /><br />
						<label style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:20px; padding-left:40px;">
						Pragyana Shopping Demo<br />
						</label>
						<label style="color:#6a8516; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px; padding-left:40px;">
						An excellence in web developement.....!!!!<br />
						</label>
					</p>
						<hr style="margin:0;" />
						<p>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							There can be two types of users in this site viz The Admin and A General User. A general user has to sign up and buy the products whereas the admin can not sign up and they have to get there email-id registered at Pragyna Softwares so that they can a see the demo by loging in as admin. An admin can upload products database, images as well as change them latter. The admin will also be able to view the orders, members, change the page setup, shipping charges and currency value also.
						</p>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
?>
