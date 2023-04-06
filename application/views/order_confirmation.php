<!DOCTYPE html>
<html>
<head>
	<title>Order Confirmation</title>
</head>
<body>
	<h1>Order Confirmation</h1>
	<p>Your order has been placed successfully!</p>
	<p>Order ID: <?php echo $order_id; ?></p>
	<p>Thank you for your purchase!</p>
</body>
<a href="<?php echo site_url('/homepage') ?>" class=" button">Home</a>
</html>