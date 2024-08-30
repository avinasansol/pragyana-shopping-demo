<?php
	session_start();
	$page="adv-search.php";
	include("include/connect-database.php");
	mysql_select_db("shop");
	include("include/top.php")
?>
<link rel="stylesheet" type="text/css" href="admin/admin-files/datepicker.css" /> 
<script type="text/javascript" src="admin/admin-files/datepicker.js"></script> 
					<div id="main-content-top">
						<h4>Advanced Search for Our Products</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
						<form name="SearchProduct" method="post" action="product-search.php">
						<table cellpadding="2" style="font-size:11px; font-weight:bold; color:#666666;" align="center">
							<tr>
								<td align="right">
						Catagory: 
								</td>
								<td align="left">
						<select name="ProCat" style="border:#666666 solid 1px; border-radius:3px; height:22px; padding-left:5px; width:120px;" >
								<?php
								if(isset($_POST['ProCat'])&&($_POST['ProCat']!="All"))
								{
								?>
									<option value="<?php echo $_POST['ProCat'];?>"><?php echo $_POST['ProCat'];?></option>
								<?php
								}
								?>
								<option value="All">all catagories</option>
								<?php
								mysql_select_db("shop");
								$sql="SELECT `catagory` FROM `product` Group by `catagory`";
								$result=mysql_query($sql);
								while($row=mysql_fetch_array($result))
								{
									?>
									<option value="<?php echo $row['catagory'];?>"><?php echo $row['catagory'];?></option>
									<?php
								}
							?>
						</select>
								</td>
							</tr>
							<tr>
								<td align="right">
								Upload Date From: 
								</td>
								<td align="left">
    							<input name="UpStartDate" id="start_dt" value="" class='datepicker' size='16' title='DD-MM-YYYY' />
								</td>
							</tr>
							<tr>
								<td align="right">
								Upload Date Upto: 
								</td>
								<td align="left">
   								<input name="UpEndDate" id="end_dt" value="" class='datepicker' size='16' title='DD-MM-YYYY' />
								</td>
							</tr>
							<tr>
								<td align="right">
								Price From: Rs 
								</td>
								<td align="left">
    							<input name="StartPrice" size='16' />
								</td>
							</tr>
							<tr>
								<td align="right">
								Price Upto: Rs 
								</td>
								<td align="left">
   								<input name="EndPrice"  size='16' />
								</td>
							</tr>
							<tr>
								<td align="right">
								Keyword: 
								</td>
								<td align="left">
								<input type="text" name="ProSearch" size='16'  />
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">
								<input type="submit" value="search" size='16' style="height:25px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;" />
								</td>
							</tr>
						</table>
						</form>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
?>