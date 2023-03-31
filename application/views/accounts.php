<?php $this->load->helper('db');?>

<!DOCTYPE html>
<html>
<head>
	<title>My Website - Collaborators</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
	<style>
		body {
			display: flex;
			flex-direction: column;
		}
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: center;
			padding: 8px;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #f2f2f2;
		}

		.container-flex {
			display: flex;
			flex-direction: column;
			height: 100%;
			overflow-y: auto;
			padding: 20px;
		}
		footer {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			text-align: left;
			padding: 10px;
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
	<div class="container-flex">
		<main>
			<div class="content">
				<h1>Collaborators</h1>
				<p>List of collaborators:</p>
				<table>
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Active</th>
							<th>User ID</th>
							<th>Edit</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach (get_collaborators() as $collaborator): ?>
						<tr>
							<td><?php echo $collaborator['name'] ?></td>
							<td><?php echo $collaborator['email'] ?></td>
							<td><?php echo $collaborator['phone'] ?></td>
							<td><?php echo $collaborator['active'] ? 'Yes' : 'No' ?></td>
							<td><?php echo $collaborator['collaborator_id'] ?></td>
							<td>
								<a href="<?php echo site_url('/alter_collaborator?id=' . $collaborator['collaborator_id']) ?>" class="btn">Edit</a>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<div class="options">
				<?php if ($this->session->userdata('permission_level') === 'admin'): ?>
					<button class="btn" onclick="location.href='<?php echo site_url('/create_colab') ?>';">Add New Collaborator</button>
				<?php endif; ?>
				</div>
			</div>
		</main>	

	</div>
		<div>
		<ul>
		<li><a href="<?php echo site_url('/homepage') ?>">Home</a></li>
		</ul>
		<p>&copy; My Website</p>
	</div>
		
</body>
</html>
