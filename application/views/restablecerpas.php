<link rel="stylesheet" href="<?php echo base_url('assets/plungins/bootstrap/css/bootstrap.min.css'); ?>">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Correo</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
    footer {
        position: absolute;
        bottom: 0;
        width: 98%;
        background-color: #e4ecfa; 
        color: white;
        padding: 10px;
        
        }
        body {
            
            min-height: 100vh;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        #container {
            max-width: 500px;
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }

        .center-text {
            text-align: center;
        }
        .center-button {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div id="container">
        <div class="header-container">
            <img src="<?php  echo base_url('IGTO4.png'); ?>" alt="Logo" width="264" height="100">
        </div>
        
        <?php echo form_open('recuperacion/restpass'); ?>
        
        <div class="form-group">
            <label for="pass">Ingresa nueva contraseña:</label>
            <input type="password" class="form-control" name="pass" value="" id="pass" required>
        </div>
        <div class="error-messages custom-error">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        </div>
        
        <input type="hidden" name="user" value="<?php echo $usuario;  ?>">
        <div class="form-group center-button">
            <input class="btn btn-primary " type="submit" value="Restablecer"> 
        </div>
        
        <?php echo form_close(); ?>
        
    </div>

    <footer >
        <div></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php  echo base_url('logo-gto.png'); ?>" alt="Logo" width="80" height="60">
                </div>
                <div class="col-md-6 text-md-right">
                    
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
<script>
$(document).ready(function() {
    $('#pass').on('keyup', function() {
        var password = $(this).val();
        var minLength = 8; // Requisito mínimo de 8 caracteres

        if (password.length < minLength) {
            $('#password-error').text('La contraseña debe tener al menos 8 caracteres');
        } else {
            $('#password-error').text('');
        }
    });
});
</script>