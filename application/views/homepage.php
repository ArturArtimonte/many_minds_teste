<!DOCTYPE html>
<html>
<head>
	<title>My Website</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>
<body>
	<div class="container">
		<header>
			
		</header>
		<main>
			<div class="content">
				<h1>Control Panel</h1>
                <div class="user">
				    <p>Welcome, <?php echo $this->session->userdata('name') ?>!</p>
			    </div>
				<p>Choose an option below:</p>
				<div class="options">
					<button class="btn" onclick="location.href='<?php echo site_url('/orders') ?>';">List Orders</button>
					<button class="btn" onclick="location.href='<?php echo site_url('/products') ?>';">List Products</button>
					<?php if ($this->session->userdata('permission_level') === 'admin'): ?>
						<button class="btn" onclick="location.href='<?php echo site_url('/accounts') ?>';">List Accounts</button>
					<?php else: ?>
						<button onclick="location.href='<?php echo site_url('/accounts') ?>';" <?php if ($this->session->userdata('permission_level') !== 'admin') { echo 'disabled'; } ?> class="btn <?php if ($this->session->userdata('permission_level') !== 'admin') { echo 'disabled-btn'; } ?>">List Accounts</button> 
					<?php endif; ?>
				</div>
				<a href="<?php echo site_url('/logout') ?>">Logout</a>
				</div>
			</div>
		</main>
		<footer>
			<p>&copy; My Website</p>
		</footer>
	</div>
</body>
</html>
