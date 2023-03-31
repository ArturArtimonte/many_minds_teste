<!DOCTYPE html>
<html>

<style>
	.container-flex {
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
	}
    table {
      border-collapse: separate;
      border-spacing: 0 10px;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
      font-weight: bold;
      text-transform: uppercase;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>

<head>
	<title>My Website - Products</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>
<body>
	<div class="container-flex">
		<main>
			<div class="content">
				<h1>Products</h1>
				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Description</th>
							<th>Price</th>
							<th>stock_quantity</th>
							<th>active</th>
							<th>edit</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($products as $product): ?>
					<tr>
						<td><?php echo $product['product_id'] ?></td>
						<td><?php echo $product['name'] ?></td>
						<td><?php echo $product['description'] ?></td>
						<td>$<?php echo $product['price'] ?></td>
						<td><?php echo $product['stock_quantity'] ?></td>
						<td><?php echo $product['active'] ?></td>
						<?php if ($this->session->userdata('permission_level') == 'admin' || $this->session->userdata('permission_level') == 'collaborator' || $this->session->userdata('permission_level') == 'supplier'): ?>
							<td><a href="<?php echo base_url('products/edit?id='.$product['product_id']) ?>">Edit</a></td>
						<?php endif; ?>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php if ($this->session->userdata('permission_level') == 'collaborator' || $this->session->userdata('permission_level') == 'admin' || $this->session->userdata('permission_level') == 'supplier'): ?>
				<a href="<?php echo site_url('/create_products') ?>" class="button">Create Product</a>
			<?php endif; ?>
		</main>
		<footer>			
			<ul>
			<li><a href="<?php echo site_url('/homepage') ?>">Home</a></li>
			</ul>
			<p>&copy; My Website</p>
		</footer>
	</div>
</body>
</html>