<?php
	session_start();
	$page="product.php";
	if(!isset($_POST['Operation']))
	{
		header("Location: index.php");
	}
	include("include/top.php");
	if($op=="ViewDetails")
	{
		if(!isset($_POST['ProductID']))
		{
			header("Location: index.php");
		}
		else
		{
?>
					<div id="main-content-top">
						<h4>Product Deatils</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<?php
							mysql_select_db("shop");
							$sql="SELECT * FROM `product` WHERE id='".$_POST['ProductID']."'";
							$result=mysql_query($sql);
							$ItemNo=1;
							while($row=mysql_fetch_array($result))
							{
								
								?>
								
									<br /><img src="product-img/<?php if(($row["img"]==null)||($row["img"]=="")){echo "no.jpg";}else{echo $row["img"];}?>" style="max-width:350px; max-height:300px; border:0px;"  /><br /><br />
								<?php
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Product ID: </label>".$row["id"]."<br />";
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Name: </label>".$row["name"]."<br />";
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Price: </label>Rs ".$row["price"]."<br />";
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Catagory: </label>".$row["catagory"]."<br />";
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Available Quantity: </label>".$row["qty"]."<br />";
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Upload Date: </label>".$row["date"]."<br />";
								echo "<label style='font-size:11px; font-weight:bold; color:#666666;'>Details: </label>".$row["desc"]."<br />";
								?>
							<form name="AddToCart" method="post" action="product.php">
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
								</select><br />
								<br />
								<input type="hidden" name="Operation" value="AddToCart" />
								<input type="hidden" name="op" value="<?php echo $op;?>" />
								<input type="hidden" name="ProductID" value="<?php echo $row['id'];?>" />
								<input type="submit" value="add to cart" style="border:#666666 solid 1px; border-radius:3px; width:100px; height:25px; padding-right:-10px;background-image:url(img/product-bg1.png); background-repeat:no-repeat; background-position:bottom left;" />
							</form>
								<?php
								$ItemNo++;
							}
						?>
						
					</div>
					<div id="main-content-bottom">
					</div>
<?php
		}
	}
	else if($op=="SearchProduct")
	{
		if(!isset($_POST['ProSearch']))
		{
			header("Location: index.php");
		}
		else
		{
?>
					<div id="main-content-top">
						<h4>Search Result For "<?php echo $_POST['ProSearch'];?>" in <?php echo $_POST['ProCat'];?> Catagory</h4>
					</div>
					<div id="main-content-mid">
						<?php
						include("include/next-page.php");
						?>
						<table cellspacing="5" cellpadding="5" border="0" align="center">
						<?php
							mysql_select_db("shop");
							$result=mysql_query("SELECT `value` FROM `settings` WHERE `function`='products_per_page'");
							if($row=mysql_fetch_array($result))
							{
								$NoOfProPerPage=(int)$row['value'];
							}
							$sql="SELECT * FROM `product` WHERE (( `name` LIKE '%".$_POST['ProSearch']."%' || `desc` LIKE '%".$_POST['ProSearch']."%' ) &&  `qty`>0)";
							if(isset($_POST['ProCat']))
							{
								if($_POST['ProCat']!="All")
								{
									$sql= $sql." && `catagory` = '".$_POST['ProCat']."'";
								}
							}
							$sql= $sql." ORDER BY name LIMIT ".$ShownLimit." , ".$NoOfProPerPage;
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
									<img src="product-img/<?php if(($row["img"]==null)||($row["img"]=="")){echo "no.jpg";}else{echo $row["img"];}?>" style="max-width:350px; max-height:300px; border:0px;"  /><br /><br />
								<label style='font-size:11px; font-weight:bold; color:#666666;'>Product Name: </label>
								<?php
									$details=$row["name"];
									$LowDet=strtolower($details);
									$WordPos=strpos($LowDet, strtolower($_POST['ProSearch']));
									$validate = "".$WordPos."";
									while($validate!="")
									{
										echo substr($details, 0, $WordPos);
										echo "<font color='white' style='background-color:blue;'>".substr($details, $WordPos, strlen($_POST['ProSearch']))."</font>";
										$details=substr($details, ($WordPos+strlen($_POST['ProSearch'])), strlen($details));
										$LowDet=substr($LowDet, ($WordPos+strlen($_POST['ProSearch'])), strlen($LowDet));
										$WordPos=strpos($LowDet, strtolower($_POST['ProSearch']));
										$validate = "".$WordPos."";
									}
									echo $details;
								?>
								<br />
								<label style='font-size:11px; font-weight:bold; color:#666666;'>Price: </label>Rs 
								<?php
									echo $row["price"];
								?>
								<br />
								<label style='font-size:11px; font-weight:bold; color:#666666;'>Details: </label>
								<?php
									$details=$row["desc"];
									$LowDet=strtolower($details);
									$WordPos=strpos($LowDet, strtolower($_POST['ProSearch']));
									$validate = "".$WordPos."";
									while($validate!="")
									{
										echo substr($details, 0, $WordPos);
										echo "<font color='white' style='background-color:blue;'>".substr($details, $WordPos, strlen($_POST['ProSearch']))."</font>";
										$details=substr($details, ($WordPos+strlen($_POST['ProSearch'])), strlen($details));
										$LowDet=substr($LowDet, ($WordPos+strlen($_POST['ProSearch'])), strlen($LowDet));
										$WordPos=strpos($LowDet, strtolower($_POST['ProSearch']));
										$validate = "".$WordPos."";
									}
									echo $details;
								?><br />
									<table align="center">
										<tr>
											<td colspan="2" align="center">
												<form name="AddToCart" method="post" action="product.php">
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
													<input type="hidden" name="op" value="<?php echo $op;?>" />
													<?php
														if(isset($_POST['ProSearch']))
														{
													?>
													<input type="hidden" name="ProSearch" value="<?php echo $_POST['ProSearch'];?>" />
													<?php
														}
														if(isset($_POST['ProCat']))
														{
													?>
													<input type="hidden" name="ProCat" value="<?php echo $_POST['ProCat'];?>" />
													<?php
														}
													?>
													<input type="hidden" name="ShownLimit" value="<?php echo $ShownLimit;?>" />
													<input type="hidden" name="ProductID" value="<?php echo $row['id'];?>" />
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
								if(($ItemNo%2==0))
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
							if($ItemNo==1)
							{
								?>
								<p style="margin:0; text-align:center; color:#FF0000;"><br />No result found for the search, you performed.</p>
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
		}
	}
	include("include/bottom.php");
?>