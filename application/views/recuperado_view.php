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
        <?php echo validation_errors(); ?>
        <?php echo form_open('recuperacion/coincidirrec'); ?>
        <p>Se te envió un codigo de recuperacion a tu correo: <?php echo $correo;  ?></p>
        <div class="form-group">
            <label for="usuario">Ingresa codigo:</label>
            <input type="text" class="form-control" name="codigo" value="" required>
        </div>
        <input type="hidden" name="user" value="<?php echo $usuario;  ?>">
        <div class="form-group center-button">
            <input class="btn btn-primary " type="submit" value="Recuperar"> 
        </div>
        
        <?php echo form_close(); ?>
    </div>
    
    
<script>
function enviarSolicitud() {
    var url = "http://187.191.30.131:4401/wsCurp/api/v1/mailer/sendMail";
    var token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpbml0RGF0ZSI6IjIwMjMtMDUtMTggMTE6NTI6MTEiLCJleHBEYXRlIjoiMjAyNC0wNS0xOCAxMTo1MjoxMSIsImlhdCI6MTY4NDQzNTkzMSwiZXhwIjoxNzE1OTcxOTMxfQ.hVO-vuctRXPISJEgI_ulVjlIjowCA72t5vnfBXdkfZ4";


    var data = {
        subject: 'Recuperacion de contraseña',
        body: '<?php echo "Se ha solicitado la recuperacion de contraseña de ".$usuario.".<br>.Ingrese este codigo en la pestaña ".$codigo;  ?> ',
        addresses: '<?php echo $correo_ ;?>'
    };

    $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function (response) {
            console.log("Respuesta del servidor:", response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud:");
            console.log("Código HTTP:", jqXHR.status);
            console.log("Estado:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta:", jqXHR.responseText);

            
            setTimeout(enviarSolicitud, 5000);
        }
    });
}

$(document).ready(function () {
    enviarSolicitud();
});
</script>


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
