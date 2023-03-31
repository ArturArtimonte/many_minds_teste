<?php
$this->load->library('session');
//var_dump($this->session->userdata('login_attempts'));
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Página de Login</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/user_handler_style.css">
</head>

<body>
  <div class="login">
    <h1>Página de Login</h1>
    <form id="login-form" action="<?php echo site_url('/login') ?>" method="post">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email">
      <label for="password">Senha:</label>
      <input type="password" id="password" name="password">
      <button type="submit">Entrar</button>
      <p>Não tem uma conta? <a href="<?= site_url('/register') ?>">Registre-se aqui</a></p>
    </form>
    <div class="error_message"></div>
  </div>

  <!-- Importando jQuery -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>

  <script>
    $(document).ready(function () {
      $("#login-form").submit(function (event) {
        event.preventDefault();
        var email = $("#email").val();
        var password = $("#password").val();

        if (email == "" || password == "") {
          $(".error_message").text("Usuário e senha são obrigatórios.");
        } else {
          $(".error_message").text("");
          $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
              console.log(response);
              var response_in = JSON.parse(response)
              if (response_in.status == 'success') {
                // Handle the successful response
                window.location.href = "<?php echo site_url('/homepage') ?>";
              } else {
                // Handle the error response
                var message = decodeURIComponent(response_in.message);
                $(".error_message").html(message);
              }
            },
            error: function (xhr, status, error) {
              // Handle the error response
              $(".error_message").text(xhr.responseText);

              // Check if there is a flashdata error message
              var flash_error = "<?php echo $this->session->flashdata('error'); ?>";
              if (flash_error) {
                $(".error_message").text(flash_error);
              }
            }
          });
        }
      });
    });
  </script>
</body>

</html>