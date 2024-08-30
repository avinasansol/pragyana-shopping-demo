
						<div style="padding-top:10px; height:30px; padding-right:20px;">
						<table align="right">
						<tr>
							<?php
							mysql_select_db("shop");
							$result=mysql_query("SELECT `value` FROM `settings` WHERE `function`='products_per_page'");
							if($row=mysql_fetch_array($result))
							{
								$NoOfProPerPage=(int)$row['value'];
							}
							if($page=="product.php")
							{
								$sql="SELECT COUNT(id) FROM product WHERE (( `name` LIKE '%".$_POST['ProSearch']."%' || `desc` LIKE '%".$_POST['ProSearch']."%' ) && `qty`>0)";
								if(isset($_POST['ProCat']))
								{
									if($_POST['ProCat']!="All")
									{
										$sql= $sql." && `catagory` = '".$_POST['ProCat']."'";
									}
								}
							}
							else if($page=="index.php")
							{
								$sql="SELECT COUNT(id) FROM product WHERE `qty`>0";
							}
							else if($page=="product-search.php")
							{
								$sql="SELECT COUNT(id) FROM `product` WHERE ";
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
							}
							$result=mysql_query($sql);
							if($row=mysql_fetch_array($result))
							{
								$NoOfPro=(int) $row[0];
							}
							$NoOfPages=0;
							$CurrPage=0;
							if($NoOfPro%$NoOfProPerPage)
							{
								$NoOfPages=(int)($NoOfPro/$NoOfProPerPage)+1;
							}
							else
							{
								$NoOfPages=(int)($NoOfPro/$NoOfProPerPage);
							}
							$CurrPage=(int)($ShownLimit/$NoOfProPerPage)+1;
							?>
							<td style="padding-top:4px;" valign="top">
								showing page <?php echo $CurrPage; ?> of <?php echo $NoOfPages;?> 
							</td>
							<?php
							if($ShownLimit>0)
							{
							?>
							<td>
							<form name="GoPrev" method="post" action="<?php echo $page;?>">
								<input type="hidden" name="Operation" value="GoPrev" />
									<?php
										if(isset($op))
										{
										?>
											<input type="hidden" name="op" value="<?php echo $op;?>" />
										<?php
										}
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
								<input type="hidden" name="ShownLimit" value="<?php echo ($ShownLimit-$NoOfProPerPage);?>" />
								<input type="submit" value="previous page" style="border:#666666 solid 1px; border-radius:3px;padding-right:-10px; background-color:#CCCCCC;" />
							</form>
							</td>
							<?php
							}
							if(($ShownLimit+$NoOfProPerPage)<$NoOfPro)
							{
							?>
							<td>
							<form name="GoNext" method="post" action="<?php echo $page;?>">
								<input type="hidden" name="Operation" value="GoNext" />
									<?php
										if(isset($op))
										{
										?>
											<input type="hidden" name="op" value="<?php echo $op;?>" />
										<?php
										}
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
								<input type="hidden" name="ShownLimit" value="<?php echo ($ShownLimit+$NoOfProPerPage);?>" />
								<input type="submit" value="next page" style="border:#666666 solid 1px; border-radius:3px;padding-right:-10px;background-color:#CCCCCC;" />
							</form>
							</td>
							<?php
							}
							?>
						</tr>
						</table>
						</div>