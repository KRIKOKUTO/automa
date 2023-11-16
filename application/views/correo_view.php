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
        width: 100%;
        background-color: #e4ecfa; 
        color: white;
        padding: 10px;
        
        }
        body {
            width: 100%
            min-height: 100vh;
        }
    </style>
</head>
<body>
    

    
<script>
function enviarSolicitud() {
    var url = "http://187.191.30.131:4401/wsCurp/api/v1/mailer/sendMail";
    var token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpbml0RGF0ZSI6IjIwMjMtMDUtMTggMTE6NTI6MTEiLCJleHBEYXRlIjoiMjAyNC0wNS0xOCAxMTo1MjoxMSIsImlhdCI6MTY4NDQzNTkzMSwiZXhwIjoxNzE1OTcxOTMxfQ.hVO-vuctRXPISJEgI_ulVjlIjowCA72t5vnfBXdkfZ4";
    var direcciones = "<?php echo $addresses; ?>";

    var data = {
        subject: 'Activacion pendiente',
        body: '<?php echo "Se ha registrado un nuevo usuario con el nombre " . $usuario . ".<br>Se espera su activacion"; ?> ',
        addresses: '<?php echo $addresses; ?>'
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

            // Reintenta la solicitud después de un intervalo de tiempo (por ejemplo, 5 segundos)
            setTimeout(enviarSolicitud, 5000);
        }
    });
}

$(document).ready(function () {
    enviarSolicitud();
});

</script>

<h1>Se envio aviso a los administradores para dar de alta tu usuario</h1>
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
