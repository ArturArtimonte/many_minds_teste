<!DOCTYPE html>
<html>
<head>
	<title>My Website - New Collaborator</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/collaborator_style.css') ?>">
</head>
<body>
	<form  method="post">
		<h1>New Collaborator</h1>
		<label for="collaborator_type">Collaborator Type:</label>
        <select id="collaborator_type" name="collaborator_type">
            <option value="new">New Collaborator</option>
            <option value="existing">Existing User</option>
        </select>

        <div id="user_select_container" style="display: none;">
            <label for="user_select">Select User:</label>
            <select id="user_select" name="user_select"></select>
        </div>

		<div id="name_field">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" required>
		</div>

		<div id="email_field">
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
		</div>

		<div id="phone_field">
			<label for="phone">Phone:</label>
			<input type="tel" id="phone" name="phone" required>
		</div>

		<div id="address_field">
            <div class="form-row">
                <div class="form-group">
                    <label for="zip_code">Zip code:</label>
                    <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="number">Number:</label>
                    <input type="text" id="number" name="number" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="complement">Complement:</label>
                    <input type="text" id="complement" name="complement" class="form-control">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="state">State:</label>
                    <input type="text" id="state" name="state" class="form-control" required>
                </div>
            </div>
        </div>

        <div id="role_field">
            <label for="role">Role:</label>
            <select id="role" name="role" disabled required>
				<option value="" selected disabled>Select a role</option>
				<option value="admin">Admin</option>
				<option value="collaborator">Collaborator</option>
				<option value="user">User</option>
				<option value="supplier">Supplier</option>
			</select>
        </div>

		<div class="options">
            <button id="create_button" name="create_button" type="submit" class="btn" >Create Collaborator</button>
			<button type="button" onclick="location.href='<?php echo site_url('/accounts') ?>' ;" class="btn cancel">Cancel</button>
		</div>
	</form>
</body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script>
changeCollaboratorType('new');

$(function() {
  // Bind the change event to the collaborator type dropdown
  $('#collaborator_type').change(function() {
    // Check if the selected value is "Existing User"
    changeCollaboratorType($(this).val());
    if ($(this).val() == 'existing') {
        // Send a GET request to the controller action to fetch a list of users
        $.get('<?php echo site_url('/get_user') ?>', function(users) {
            // Clear the existing options in the select dropdown
            $('#user_select').empty();
            // Add the "Select User" option
            $('#user_select').append($('<option>', {
            value: '',
            text: 'Select User',
            data: {
                user: null
            }
            }));
            // Add each user as an option in the select dropdown
            $.each(users, function(index, user) {
            $('#user_select').append($('<option>', {
                value: user.user_id,
                text: user.name,
                data: {
                user: user
                }
            }));
            });
            // Show the user select dropdown
            $('#user_select_container').show();
            // Disable the name and email fields
            $('#name, #email').prop('disabled', true);
            // Enable the role field
            $('#role').prop('disabled', false);
        }, 'json'); // add dataType option
    } else {
        // Hide the user select dropdown
        $('#user_select_container').hide();
        // Enable the name, email, and role fields
        $('#name, #email, #role').prop('disabled', false);
        $(' #role').prop('disabled', true);
        // Clear the fields
        $('#name, #email, #role').val('');
    }
  });

  // Bind the change event to the user select dropdown
  $('#user_select').change(function() {
    // Get the selected user object
    var selectedUser = $(this).find('option:selected').data('user');
    // Set the name field to the corresponding value from the selected user object
    $('#name').val(selectedUser.name);
    // Set the email field to the corresponding value from the selected user object and disable the field
    $('#email').val(selectedUser.email).prop('disabled', true);
    // Set the role field to the corresponding value from the selected user object
    $('#role').val(selectedUser.permission_level);
    // Disable the name, email, and role fields
    $('#name, #email').prop('disabled', true);
  });

  // Load the default user when the page loads
  var defaultUser = $('#user_select').find('option:selected').data('user');
  $('#name').val(defaultUser.name);
  $('#email').val(defaultUser.email).prop('disabled', true);
  $('#role').val(defaultUser.permission_level);

  // Disable the name, email, and role fields
  $('#name, #email').prop('disabled', true);
});

function create_collaborator() {
  // Get the form data
  var name = $('#name').val();
  var email = $('#email').val();
  var phone = $('#phone').val();
  var address = $('#address').val();
  var zip_code = $('#zip_code').val();
  var street = $('#street').val();
  var number = $('#number').val();
  var complement = $('#complement').val();
  var city = $('#city').val();
  var state = $('#state').val();
  var role = $('#role').val();
  var user_id = $('#user_select').val();

  // Send an Ajax request to the server
  $.ajax({
    url: '/create_collaborator',
    method: 'POST',
    data: {
      name: name,
      email: email,
      phone: phone,
      address: address,
      zip_code: zip_code,
      street: street,
      number: number,
      complement: complement,
      city: city,
      state: state,
      permission_level: role,
      user_id: user_id
    },
    success: function(response) {
      // Handle the success response
      console.log(response);
    },
    error: function(xhr, status, error) {
      // Handle the error response
      console.error(xhr.responseText);
    }
  });
}

function changeCollaboratorType(type) {
  if (type === 'new') {
    $('#create_button').attr('onclick', 'create_collaborator_no_user()');
  } else if (type === 'existing') {
    $('#create_button').attr('onclick', 'create_collaborator()');
  }
}

function create_collaborator_no_user() {
    // Get the form data
  var name = $('#name').val();
  var email = $('#email').val();
  var phone = $('#phone').val();
  var address = $('#address').val();
  var zip_code = $('#zip_code').val();
  var street = $('#street').val();
  var number = $('#number').val();
  var complement = $('#complement').val();
  var city = $('#city').val();
  var state = $('#state').val();

  // Send an Ajax request to the server
  $.ajax({
    url: '/create_collaborator_no_user',
    method: 'POST',
    data: {
      name: name,
      email: email,
      phone: phone,
      address: address,
      zip_code: zip_code,
      street: street,
      number: number,
      complement: complement,
      city: city,
      state: state,
    },
    success: function(response) {
      // Handle the success response
      console.log(response);
    },
    error: function(xhr, status, error) {
      // Handle the error response
      console.error(xhr.responseText);
    }
  });
}


</script>
</html>
