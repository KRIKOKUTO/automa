<link rel="stylesheet" href="<?php echo base_url('assets/plungins/bootstrap/css/bootstrap.min.css'); ?>">
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .custom-error {
            color: red;
        }

        #container {
            max-width: 500px;
            min-width: 450px;
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
        footer {
        
        bottom: 0;
        width: 100%;
        background-color: #e4ecfa; 
        color: white;
        padding: 10px;
        
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
        flex: 1;
        }
        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;

        }
        


    </style>
</head>
<body>
    <div class="header-container" style="padding: 50px">
        
    </div>

    
    <?php echo form_open('auth/registro'); ?>
    <div id="container">
        <div class="header-container">
            <img src="<?php  echo base_url('IGTO4.png'); ?>" alt="Logo" width="264" height="100">
        </div>
        
        <div class="form-group">
            <label class="form-label" for="nombre">Nombre:</label>
            <input type="text"  class="form-control" name="nombre" value="<?php echo set_value('nombre'); ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="usuario">Usuario:</label>
            <input type="text" class="form-control" name="usuario" value="<?php echo set_value('usuario'); ?>" required>
        </div>
        <div  class="form-group">
            
            <label class="form-label" for="departamento">Departamento:</label><br>
            <select class="btn btn-primary dropdown-toggle" name="departamento" required>
                <option value="planeacion">Planeación</option>
                <option value="TI">TI</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label" for="correo">Correo:</label>
            <input type="text" class="form-control" name="correo" value="<?php echo set_value('correo'); ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Contraseña:</label>
            <input type="password" class="form-control" name="pass" id="password" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="confirm_pass">Confirmar Contraseña:</label>
            <input type="password" class="form-control" name="confirm_pass" required>
        </div>
        <div class="error-messages custom-error">
            <p><?php echo validation_errors(); ?></p>
            <p><?php if (isset($mensaje)) {
                echo $mensaje;
            } ?></p>
        </div>
        <div  class="form-group center-button">
            <input type="submit" class="btn btn-primary " value="Registrarse">
        </div>
        
        <div>
        <p class="center-text">¿Ya tienes una cuenta? <a href="<?php echo base_url('auth/login'); ?>">Iniciar Sesión</a></p>
            <div id="password-error" style="color: red;"></div>
        </div>
        

        
        
    </div>
    <?php echo form_close(); ?>
    <footer >
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
    $('#password').on('keyup', function() {
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

