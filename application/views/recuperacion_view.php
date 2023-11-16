<link rel="stylesheet" href="<?php echo base_url('assets/plungins/bootstrap/css/bootstrap.min.css'); ?>">
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <style>
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
        footer {
        position: absolute;
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
        h1 {
            margin: 0; 
        }
        .texto_ {
            font-family: 'Arial', serif; 
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    
    
        

    
    <div id="container">
        <div class="header-container">
            <img src="<?php  echo base_url('IGTO4.png'); ?>" alt="Logo" width="264" height="100">
        </div>
        <?php echo validation_errors(); ?>
        <?php echo form_open('recuperacion/generarrec'); ?>
        <div class="form-group">
            <label for="usuario">Usuario a recuperar:</label>
            <input type="text" class="form-control" name="usuario" value="<?php echo set_value('usuario'); ?>" required>
        </div>
        <div class="form-group center-button">
            <input class="btn btn-primary " type="submit" value="Recuperar"> 
        </div>
        <div>
            <p class="center-text">¿Ya tienes cuenta? <a href="<?php echo base_url('auth/login'); ?>">Iniciar sesion</a></p>
        </div>
        <?php echo form_close(); ?>
    </div>
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
