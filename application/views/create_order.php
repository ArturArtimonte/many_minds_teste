<!DOCTYPE html>
<html>

<head>
	<title>Create Order</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>

<body>
	<div class="container-flex">
		<main>
			<div class="content">
				<h1>Create Order</h1>
				<form method="post" action="<?php echo site_url('create_order') ?>">
					<label for="supplier_id">Supplier:</label>
					<select id="supplier_id" name="supplier_id">
						<?php foreach ($suppliers as $supplier): ?>
							<option value="<?php echo $supplier['collaborator_id'] ?>"><?php echo $supplier['name'] ?>
							</option>
						<?php endforeach; ?>
					</select>
					<br>
					<label for="product_id">Product:</label>
					<select id="product_id" name="product_id">
						<?php foreach ($products as $product): ?>
							<option value="<?php echo $product['product_id'] ?>"><?php echo $product['name'] ?></option>
						<?php endforeach; ?>
					</select>
					<label for="quantity">Quantity:</label>
					<input type="number" id="quantity" name="quantity" value="1" min="1">
					<button type="submit" name="add_item" value='1'>Add Item</button>
				</form>
				<br>
				<table>
					<thead>
						<tr>
							<th>Product</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Subtotal</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($items as $key => $item): ?>
							<tr>
								<td>
									<?php echo $item['name'] ?>
								</td>
								<td>
									<?php echo $item['quantity'] ?>
								</td>
								<td>$
									<?php echo $item['price'] ?>
								</td>
								<td>$
									<?php echo $item['subtotal'] ?>
								</td>
								<td><a href="<?php echo site_url('/remove_item/' . $key) ?>">Remove</a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" style="text-align: right">Total:</th>
							<th>$
								<?php echo $total ?>
							</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<button onclick="window.location.href='<?php echo site_url('/create_order_db') ?>'">Save Order</button>
		</main>
		<footer>
			<ul>
				<li><a href="<?php echo site_url('/orders') ?>">Orders</a></li>
			</ul>
		</footer>
	</div>
</body>