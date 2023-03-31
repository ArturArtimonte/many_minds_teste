<?php 
    $this->load->helper('db');
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $collaborator = get_collaborator_from_id($id);
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Website - Alter Collaborator</title>
	<link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('/css/alter_collaborator_style.css') ?>">
</head>
<body>
    <main>
        <div class="container">
            <h1>Alter Collaborator</h1>
            <form method="post">
                <div class="collaborator-fields">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $collaborator['name'] ?>"><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $collaborator['email'] ?>"><br>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $collaborator['phone'] ?>"><br>

                    <label for="active">Active:</label>
                    <input type="checkbox" id="active" name="active" <?php if ($collaborator['active'] == 1 ) {echo 'checked'; }?>><br>
                </div>

                <div class="address-fields">
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

                <input type="hidden" id="collaborator_id" name="collaborator_id" value="<?php echo $collaborator['collaborator_id'] ?>">
                <button type="submit" class="btn">Save Changes</button>
            </form>
        </div>
        <ul>
			<li><a href="<?php echo site_url('/homepage') ?>">Home</a></li>
			<li><a href="<?php echo site_url('/accounts') ?>">Collaborators</a></li>
		</ul>
		<p>&copy; My Website</p>
    </main>
</body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('form').on('submit', function(e) {
      e.preventDefault(); // prevent the form from submitting normally

      // get the form data
      var formData = $('form').serialize();

      // get the collaborator ID
      var collaboratorId = $('#collaborator_id').val();
      console.log(collaboratorId);
      // send the AJAX request
      $.ajax({
        url: 'update_collaborator?id=' + collaboratorId,
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log(response);
          // do something with the response
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>

</html>
