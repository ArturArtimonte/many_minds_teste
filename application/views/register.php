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
        <div class="invalid-feedback username-error-message"></div>
        <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control email-input" id="email" name="email" required>
        <div class="invalid-feedback email-error-message"></div>
        <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control password-input" id="password" name="password" required>
        <div class="invalid-feedback password-error-message"></div>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" class="form-control confirm-password-input" id="confirm_password" name="confirm_password" required>
        <div class="invalid-feedback confirm-password-error-message"></div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary" id="register-button">Register</button>
      </div>
    </form>
  </div>

  <!-- jQuery script for form validation -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#register-button').click(function() {
      var username = $('.username-input').val();
      var email = $('.email-input').val();
      var password = $('.password-input').val();
      var confirm_password = $('.confirm-password-input').val();

      // Check that the username only contains letters
      if (!/^[a-zA-Z]+$/.test(username)) {
        $('.username-input').addClass('is-invalid');
        $('.username-error-message').text('Username must only contain letters');
      } else {
        $('.username-input').removeClass('is-invalid');
        $('.username-error-message').text('');
      }

      // Check that the email is in a valid format
      if (!/\S+@\S+\.\S+/.test(email)) {
        $('.email-input').addClass('is-invalid');
        $('.email-error-message').text('Please enter a valid email address');
      } else {
        $('.email-input').removeClass('is-invalid');
        $('.email-error-message').text('');
      }

      // Check that the password is at least 8 characters long and contains at least one number
      if (password.length < 8 || !/\d/.test(password)) {
        $('.password-input').addClass('is-invalid');
        $('.password-error-message').text('Password must be at least 8 characters long and contain at least one number');
      } else {
        $('.password-input').removeClass('is-invalid');
        $('.password-error-message').text('');
      }

      // Check that the confirm password matches the password
      if (confirm_password !== password) {
        $('.confirm-password-input').addClass('is-invalid');
        $('.confirm-password-error-message').text('Passwords do not match');
      } else {
        $('.confirm-password-input').removeClass('is-invalid');
        $('.confirm-password-error-message').text('');
      }
    });
  });
  </script>
</body>
</html>
