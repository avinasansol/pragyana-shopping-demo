<?php
include("../include/connect-database.php");
mysql_select_db("shop");
$result=mysql_query("SELECT `name` FROM `admin` WHERE `admin`.`username`='".$_SESSION['LogdUsrDet'][1]."'");
if($row=mysql_fetch_array($result))
{
$AdminName=$row['name'];
}
else
{
header("Location: ../");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="admin-files/admin.css" />
<link rel="shortcut icon" href="../img/icon.png">
<?php
if($page=="shipping.php")
{
	?>
	<script type="text/javascript">
		function ValidateDelete()
		{
			if(confirm("Are you sure, you want to delete the slab?"))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	</script>
	<?php
}
if($page=="order-bin.php")
{
?>
	<script type="text/javascript">
		function ValidateMarking()
		{
			if(confirm("Once marked as delivered, can not be undone.\nAre you sure, you want to mark the order?"))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	</script>
<?php
}
if(isset($_REQUEST['OrderID']))
{
	?>
<script language="JavaScript">
 var gAutoPrint = true;

function printSpecial()
 {
 if (document.getElementById != null)
 {
 var html = '<HTML>\n<HEAD>\n';

if (document.getElementsByTagName != null)
 {
 var headTags = document.getElementsByTagName("head");
 if (headTags.length > 0)
 html += headTags[0].innerHTML;
 }

 html += '\n</HE>\n<BODY>\n';

 var contentElem = document.getElementById("content");

 if (contentElem != null)
 {
 html += contentElem.innerHTML;
 }
 else
 {
 alert("Could not find the content function");
 return;
 }

 html += '\n</BO>\n</HT>';

 var printWin = window.open("","printSpecial");
 printWin.document.open();
 printWin.document.write(html);
 printWin.document.close();
 if (gAutoPrint)
 printWin.print();
 }
 else
 {
 alert("The print ready feature is only available if you are using an browser. Please update your browswer.");
 }
 }

function printSpecialWithoutAns()
 {
 if (document.getElementById != null)
 {
 var html = '<HTML>\n<HEAD>\n';

if (document.getElementsByTagName != null)
 {
 var headTags = document.getElementsByTagName("head");
 if (headTags.length > 0)
 html += headTags[0].innerHTML;
 }

 html += '\n</HE>\n<BODY>\n';

 var contentWithoutAnsElem = document.getElementById("contentWithoutAns");

 if (contentWithoutAnsElem != null)
 {
 html += contentWithoutAnsElem.innerHTML;
 }
 else
 {
 alert("Could not find the contentWithoutAns function");
 return;
 }

 html += '\n</BO>\n</HT>';

 var printWin = window.open("","printSpecial");
 printWin.document.open();
 printWin.document.write(html);
 printWin.document.close();
 if (gAutoPrint)
 printWin.print();
 }
 else
 {
 alert("The print ready feature is only available if you are using an browser. Please update your browswer.");
 }
 }
</script>
	<?php
	}
?>
<script type="text/javascript" src="admin-files/jquery.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
$("h3").click(function(){
    $(this).parent("#main-content-top").parent("#main-content").children("#main-content-mid").children("#main-content-mid-left").toggle("slow");
  });
});
</script>
<title>Admin- Control Panel</title>
</head>

<body>
	<div id="menu">
		<div class="red">
			<div id="slatenav">
				<ul>
					<li><a href="../index.php" title="Home">Home</a></li>
					<li><a href="../how-to-order.php" title="How to Order">How to Order</a></li>
					<li><a href="../shipping-charges.php" title="Shipping Charges">Shipping Charges</a></li>
					<li><a href="../about-us.php" title="About Us">About Us</a></li>
					<li><a href="../contact-us.php" title="Contact Us">Contact Us</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="wraper" style="min-height:550px;">
		<div id="head">
			<a href="../logout.php">Log Out</a>
			<h1 style="float:right; margin:17px 15px 0 0; padding-top:5px; text-align:center; font-size:14px;">Logged In As Administrator (<?php echo $AdminName;?>)</h1>
			<h1 style="margin:0; padding:60px 0 0 110px; font-style:italic; font:'Times New Roman', Times, serif; font-size:24px;">Control Panel</h1>
		</div>
		<div id="main-content">
			<div id="main-content-top">
				<h3>click here to hide/show the tools</h3>
			</div>
			<div id="main-content-mid">
				<div id="main-content-mid-left">
					<h4>Administrative Tools</h4>
					<table align="center" width="780px" border="0">
						<tr>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="excel-upload.php">
									<img src="admin-files/excel-upload.png" /><br />
									<b>Excel Uploader</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="image-upload.php">
									<img src="admin-files/image-upload.png" /><br />
									<b>Image Uploader</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="product-bin.php">
									<img src="admin-files/product-bin.png" /><br />
									<b>Product Bin</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="order-bin.php">
									<img src="admin-files/order-bin.png" /><br />
									<b>Order Bin</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="delivery.php">
									<img src="admin-files/delivery.png" /><br />
									<b>Delivery Viewer</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="members.php">
									<img src="admin-files/members.png" /><br />
									<b>Members Viewer</b>
								</a>
							</td>
						</tr>
						<tr>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="page-setup.php">
									<img src="admin-files/page-setup.png" /><br />
									<b>Page Setup Editor</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="shipping.php">
									<img src="admin-files/shipping-charge.png" /><br />
									<b>Shipping Editer</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="currency.php">
									<img src="admin-files/currency.png" /><br />
									<b>Currency Editer</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="discount.php">
									<img src="admin-files/sold-products.png" /><br />
									<b>Discount Editer</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="email.php">
									<img src="admin-files/email-sender.png" /><br />
									<b>Email Sender</b>
								</a>
							</td>
							<td width="130px" height="130px" align="center" valign="middle" class="tools">
								<a href="webmail.php">
									<img src="admin-files/webmail.png" /><br />
									<b>Webmail Viewer</b>
								</a>
							</td>
						</tr>
					</table>
				</div>
				<div id="main-content-mid-right">