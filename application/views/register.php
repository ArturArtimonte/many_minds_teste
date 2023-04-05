<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/user_handler_style.css">
</head>
<body>
  <!-- User handler form -->
  <div class="register">
    <h1>User Handler</h1>

    <form method="post" action="<?php echo base_url('/register'); ?>">
      <div class="form-group">
        <label for="username">Name:</label>
        <input type="text" class="form-control username-input" id="username" name="username" required>
        <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control email-input" id="email" name="email" required>
        <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control password-input" id="password" name="password" required>
        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" class="form-control confirm-password-input" id="confirm_password" name="confirm_password" required>
        <?php echo form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary" id="register-button">Register</button>
      </div>
    </form>
  </div>

  <!-- jQuery script for form validation -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  
</body>
</html>
