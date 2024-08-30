<?php
	session_start();
	$page="index.php";
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Brand New Products</h4>
					</div>
					<div id="main-content-mid">
						<?php
						include("include/next-page.php");
						?>
						<table cellspacing="5" cellpadding="5" border="0"><?php
							mysql_select_db("shop");
							$result=mysql_query("SELECT `value` FROM `settings` WHERE `function`='products_per_page'");
							if($row=mysql_fetch_array($result))
							{
								$NoOfProPerPage=(int)$row['value'];
							}
							$sql="SELECT id, name, price, qty, img FROM `product` WHERE `qty`>0 ORDER BY date DESC LIMIT ".$ShownLimit." , ".$NoOfProPerPage;
							$result=mysql_query($sql);
							$ItemNo=1;
							while($row=mysql_fetch_array($result))
							{
								if($ItemNo%2)
								{
									?>
									
							<tr valign="top">
									<?php
								}
								?>
								
								<td align="center" valign="bottom" style="padding-top:50px; text-align:center;" width="434px" >
									<img src="product-img/<?php if(($row["img"]==null)||($row["img"]=="")){echo "no.jpg";}else{echo $row["img"];}?>" style=" max-width:350px; max-height:300px; border:0px;"  /><br /><br />
								<label style='font-size:11px; font-weight:bold; color:#666666;'>Product Name: </label><?php echo $row["name"];?><br />
								<label style='font-size:11px; font-weight:bold; color:#666666;'>Price: </label>Rs <?php echo $row["price"];?><br />
									<table align="center">
										<tr>
											<td colspan="2" align="center">
												<form name="AddToCart" method="post" action="index.php">
													<label style='font-size:11px; font-weight:bold; color:#666666;'>Order Quantity: </label>
													<select name="OrdrQty">
													<?php 
														for($i=1;$i<=$row["qty"];$i++)
														{
														?>
															<option value="<?php echo $i;?>"><?php echo $i;?></option>
														<?php
														}
													?>
													</select>
											</td>
										</tr>
										<tr>
											<td>
													<input type="hidden" name="Operation" value="AddToCart" />
													<input type="hidden" name="ProductID" value="<?php echo $row['id'];?>" />
													<input type="hidden" name="ShownLimit" value="<?php echo $ShownLimit;?>" />
													<input type="submit" value="add to cart" style="border:#666666 solid 1px; border-radius:3px; width:100px; height:25px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;" />
												</form>
											</td>
											<td>
												<form name="ViewDetails" method="post" action="product.php">
													<input type="hidden" name="Operation" value="ViewDetails" />
													<input type="hidden" name="ProductID" value="<?php echo $row['id'];?>" />
													<input type="submit" value="view details" style="border:#666666 solid 1px; border-radius:3px; width:100px; height:25px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;" />
												</form>
											</td>
										</tr>
									</table>
								</td>
								<?php
								if($ItemNo%2==0)
								{
									?>
									
							</tr>
									<?php
								}
								$ItemNo++;
							}
								if($ItemNo%2==0)
								{
									if($ItemNo!=2)
									{
									?>
								
								<td>
								</td>
									<?php
									}
									?>
										
							</tr>
									<?php
								}
						?>
						
						</table>
						<?php
						include("include/next-page.php");
						?>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
	if(isset($_REQUEST['Email']))
	{
	?>
		<script type="text/javascript">
			alert("You have signed up successfully.\nYour password has been mailed to <?php echo $_REQUEST['Email'];?>\nPlease login using that password.");
		</script>
	<?php
	}
?>