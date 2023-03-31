<!DOCTYPE html>
<html>
<head>
	<title>My Website - Edit Product</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>
<body>
	<div class="container">
		<main>
			<div class="content">
				<h1>Edit Product</h1>
				<form action="<?php echo base_url('products/update_product') ?>" method="post">
					<input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>
					<br>
					<label for="description">Description:</label>
					<textarea id="description" name="description"><?php echo $product['description']; ?></textarea>
					<br>
					<label for="price">Price:</label>
					<input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
					<br>
					<label for="stock_quantity">Stock Quantity:</label>
					<input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?php echo $product['stock_quantity']; ?>" required>
					<br>
					<label for="active">Active:</label>
					<input type="checkbox" id="active" name="active" value="1" <?php if($product['active']) echo 'checked'; ?>>
					<br>
					<input type="submit" value="Update Product">
				</form>
			</div>
		</main>
		<footer>
			<p>&copy; My Website</p>
		</footer>
	</div>
</body>
</html>
