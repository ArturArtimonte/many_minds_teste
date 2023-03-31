<!DOCTYPE html>
<html>
<head>
	<title>My Website - Create Product</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>
<body>
	<div class="container">
		<main>
			<div class="content">
				<h1>Create Product</h1>
				<form action="<?php echo base_url('products/create_product_in_db') ?>" method="post">
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" required>
					<br>
					<label for="description">Description:</label>
					<textarea id="description" name="description"></textarea>
					<br>
					<label for="price">Price:</label>
					<input type="number" id="price" name="price" step="0.01" min="0" required>
					<br>
					<label for="stock_quantity">Stock Quantity:</label>
					<input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
					<br>
					<label for="active">Active:</label>
					<input type="checkbox" id="active" name="active" value="1" checked>
					<br>
					<input type="submit" value="Create Product">
				</form>
			</div>
		</main>
		<footer>
			<p>&copy; My Website</p>
		</footer>
	</div>
</body>
</html>
