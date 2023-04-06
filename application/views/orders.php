<?php
$this->load->library('session');
?>
<!DOCTYPE html>
<html>

<style>
	.container-flex {
		margin: 50px auto;
		padding: 20px;
		background-color: #fff;
		border-radius: 5px;
		box-shadow: 0 0 10px rgba(0, 0, 0, .2);
	}

	table {
		border-collapse: separate;
		border-spacing: 0 10px;
		width: 100%;
	}

	th,
	td {
		padding: 12px;
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

	.table-actions {
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.btn-edit {
		background-color: #f2f2f2;
		color: #000;
		padding: 6px 12px;
		border-radius: 5px;
		font-weight: bold;
		text-transform: uppercase;
		text-decoration: none;
	}
</style>

<head>
	<title>My Website - Orders</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>

<body>
	<div class="container-flex">
		<main>
			<div class="content">
				<h1>Orders</h1>
				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>Observations</th>
							<th>User</th>
							<th>Status</th>
							<th>Order Items</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($orders as $order): ?>
							<?php if ($order['status'] === 'active'): ?>
								<tr>
									<td>
										<?php echo $order['order_id'] ?>
									</td>
									<td>
										<?php echo $order['observations'] ?>
									</td>
									<td>
										<?php echo $order['user_id'] ?>
									</td>
									<td>
										<?php echo $order['status'] ?>
									</td>
									<td>
										<ul>
											<?php foreach ($order['order_items'] as $item): ?>
												<li>
													<?php echo $item['product_name'] ?> (
													<?php echo $item['quantity'] ?> x $
													<?php echo $item['product_price'] ?>)
												</li>
											<?php endforeach; ?>
										</ul>
									</td>
									<td class="table-actions">
										<?php if ($this->session->userdata('permission_level') == 'admin' || $this->session->userdata('permission_level') == 'collaborator' || $this->session->userdata('permission_level') == 'supplier'): ?>
											<a href="#" class="btn-edit"
												onclick="setOrderId('<?php echo $order['order_id'] ?>')">Edit</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php if ($this->session->userdata('permission_level') == 'collaborator' || $this->session->userdata('permission_level') == 'admin' || $this->session->userdata('permission_level') == 'user'): ?>
				<a href="<?php echo site_url('/create_order') ?>" class="button">Create Order</a>
			<?php endif; ?>
		</main>
		<a href="<?php echo site_url('/homepage') ?>" class=" button">Home</a>
	</div>
	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<script>
		function setOrderId(orderId) {
			$.ajax({
				type: 'POST',
				url: '/set_order_id',
				data: { orderId: orderId },
				success: function (response) {
					// Session variable has been set
					// Redirect to the edit page
					window.location.href = '<?php echo base_url('/update_order') ?>';
				}
			});
		}
	</script>
</body>