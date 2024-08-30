<?php
	session_start();
	$page="product-search.php";
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>Search Results</h4>
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
							$sql="SELECT * FROM `product` WHERE ";
							$i=0;
							if( (isset($_POST['ProSearch'])) && (($_POST['ProSearch']!="") || ($_POST['ProSearch']!=null)) )
							{
								$sql= $sql." ( `name` LIKE '%".$_POST['ProSearch']."%' || `desc` LIKE '%".$_POST['ProSearch']."%' )";
								$i++;
							}
							if( (isset($_POST['ProCat'])) && ($_POST['ProCat']!="All") )
							{
								if($i>0)
								{
								$sql= $sql." && ";
								}
								$sql= $sql." `catagory` = '".$_POST['ProCat']."'";
								$i++;
							}
							if( ( (isset($_POST['UpStartDate'])) && (($_POST['UpStartDate']!="") || ($_POST['UpStartDate']!=null)) ) && ( (isset($_POST['UpEndDate'])) && (($_POST['UpEndDate']!="") || ($_POST['UpEndDate']!=null)) ) )
							{
								$StartDate=date('Y-m-d', strtotime($_REQUEST['UpStartDate']));
								$EndDate=date('Y-m-d', strtotime($_REQUEST['UpEndDate']));
								$error="";
								if(($StartDate=="1970-01-01")&&($EndDate=="1970-01-01"))
								{
									$error="Please enter a valid Start Date and End Date.";
								}
								else if($StartDate=="1970-01-01")
								{
									$error="Please enter a valid Start Date.";
								}
								else if($EndDate=="1970-01-01")
								{
									$error="Please enter a valid End Date.";
								}
								else if($error=="")
								{
									if($i>0)
									{
										$sql= $sql." && ";
									}
									$sql= $sql."  `date` BETWEEN DATE_FORMAT('".$StartDate."','%Y-%m-%d') AND DATE_FORMAT('".$EndDate."','%Y-%m-%d')";
									$i++;
								}
							}
							else if( (isset($_POST['UpStartDate'])) && (($_POST['UpStartDate']!="") || ($_POST['UpStartDate']!=null)) )
							{
								$StartDate=date('Y-m-d', strtotime($_REQUEST['UpStartDate']));
								$error="";
								if($StartDate=="1970-01-01")
								{
									$error="Please enter a valid Start Date.";
								}
								else if($StartDate=="1970-01-01")
								{
									$error="Please enter a valid Start Date.";
								}
								else if($error=="")
								{
									if($i>0)
									{
										$sql= $sql." && ";
									}
									$sql= $sql."  `date` > DATE_FORMAT('".$StartDate."','%Y-%m-%d') ";
									$i++;
								}
							}
							else if( (isset($_POST['UpEndDate'])) && (($_POST['UpEndDate']!="") || ($_POST['UpEndDate']!=null)) )
							{
								$EndDate=date('Y-m-d', strtotime($_REQUEST['UpEndDate']));
								$error="";
								if($EndDate=="1970-01-01")
								{
									$error="Please enter a valid End Date.";
								}
								else if($EndDate=="1970-01-01")
								{
									$error="Please enter a valid End Date.";
								}
								else if($error=="")
								{
									if($i>0)
									{
										$sql= $sql." && ";
									}
									$sql= $sql."  `date` < DATE_FORMAT('".$EndDate."','%Y-%m-%d')";
									$i++;
								}
							}
							if( ( (isset($_POST['StartPrice'])) && (($_POST['StartPrice']!="") || ($_POST['StartPrice']!=null)) ) && ( (isset($_POST['EndPrice'])) && (($_POST['EndPrice']!="") || ($_POST['EndPrice']!=null)) ) )
							{
								$error="";
								if(!preg_match('/^[0-9]{1,}$/', $_POST['StartPrice']))
								{
									$error="Please enter a valid start price.";
								}
								else if(!preg_match('/^[0-9]{1,}$/', $_POST['EndPrice']))
								{
									$error="Please enter a valid end price.";
								}
								else if($error=="")
								{
									if($i>0)
									{
										$sql= $sql." && ";
									}
									$sql= $sql." `price` BETWEEN ".$_POST['StartPrice']." AND ".$_POST['EndPrice'];
									$i++;
								}
							}
							else if( (isset($_POST['StartPrice'])) && (($_POST['StartPrice']!="") || ($_POST['StartPrice']!=null)) )
							{
								$error="";
								if(!preg_match('/^[0-9]{1,}$/', $_POST['StartPrice']))
								{
									$error="Please enter a valid start price.";
								}
								else if($error=="")
								{
									if($i>0)
									{
										$sql= $sql." && ";
									}
									$sql= $sql." `price` > ".$_POST['StartPrice'];
									$i++;
								}
							}
							else if( (isset($_POST['EndPrice'])) && (($_POST['EndPrice']!="") || ($_POST['EndPrice']!=null)) ) 
							{
								$error="";
								if(!preg_match('/^[0-9]{1,}$/', $_POST['EndPrice']))
								{
									$error="Please enter a valid end price.";
								}
								else if($error=="")
								{
									if($i>0)
									{
										$sql= $sql." && ";
									}
									$sql= $sql." `price` < ".$_POST['EndPrice'];
									$i++;
								}
							}
							if($i==0)
							{
								$sql= $sql." 1 ";
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
							if( (isset($_POST['ProSearch'])) && (($_POST['ProSearch']!="") || ($_POST['ProSearch']!=null)) )
							{
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
							if( (isset($_POST['ProSearch'])) && (($_POST['ProSearch']!="") || ($_POST['ProSearch']!=null)) )
							{
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
							}
									echo $details;
								?><br />
									<table align="center">
										<tr>
											<td colspan="2" align="center">
												<form name="AddToCart" method="post" action="product-search.php">
													<input type="hidden" name="Operation" value="AddToCart" />
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
										if(isset($_POST['UpStartDate']))
										{
										?>
											<input type="hidden" name="UpStartDate" value="<?php echo $_POST['UpStartDate'];?>" />
										<?php
										}
										if(isset($_POST['UpEndDate']))
										{
										?>
											<input type="hidden" name="UpEndDate" value="<?php echo $_POST['UpEndDate'];?>" />
										<?php
										}
										if(isset($_POST['StartPrice']))
										{
										?>
											<input type="hidden" name="StartPrice" value="<?php echo $_POST['StartPrice'];?>" />
										<?php
										}
										if(isset($_POST['EndPrice']))
										{
										?>
											<input type="hidden" name="EndPrice" value="<?php echo $_POST['EndPrice'];?>" />
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
	include("include/bottom.php");
?>