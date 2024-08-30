<?php
	session_start();
	$page="thanks.php";
	include("include/connect-database.php");
	mysql_select_db("shop");
	include("include/top.php");
?>
					<div id="main-content-top">
						<h4>How To Order</h4>
					</div>
					<div id="main-content-mid" style="text-align:center;">
						<br /><br />
						<p style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:17px;">
							STEP 1: If you are a new user, click the link "New user? click here to sign up" or if you are already a user, enter your email id and password in the provided field and then click Log In.<br />
						</p>
						<img src="img/step-1.jpg" style="max-width:650px;" /><br />
						<br /><br />
						<p style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:17px;">
							STEP 2: Go to Home or search some product and then find the product, you want to order.<br />Then click "add to cart" button, below the product image.<br />
						</p>
						<img src="img/step-2.jpg" style="max-width:650px;" /><br />
						<br /><br />
						<p style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:17px;">
							STEP 3: Click on "View Details" in YOUR SHOPPING CART box.<br />
						</p>
						<img src="img/step-3.jpg" style="max-width:650px;" /><br />
						<br /><br />
						<p style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:17px;">
							STEP 4: Click on "Order Now" button in Your Shopping Cart.<br />
						</p>
						<img src="img/step-4.jpg" style="max-width:650px;" /><br />
						<br /><br />
						<p style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:17px;">
							STEP 5: Provide the shipping address and then click "CONFIRM ORDER" button<br />after selecting the payment option.<br />
						</p>
						<img src="img/step-5.jpg" style="max-width:650px;" /><br />
						<br /><br />
						<p style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:17px; margin-bottom:-12px;">
							STEP 6: After confirmation, an invoice will be generated and you will be taken to paypal,<br />where you will need to pay the money by your debit card/ credit card/ master card/ PayPal Ac.<br />
							<br /><br /><br />
						</p>
					</div>
					<div id="main-content-bottom">
					</div>
<?php
	include("include/bottom.php");
?>