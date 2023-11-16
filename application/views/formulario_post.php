<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Formulario POST</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/plungins/bootstrap/css/bootstrap.min.css'); ?>">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h1>Formulario POST</h1>
                    <form id="form1" action="" method="POST">
                        <label for="nombre" class="control-label">Ingresa tu nombre</label>
                        <input class="form-control" type="text" id="nombre" name="nombre">
                        <button class="btn btn-primary" type= "sumit" id="enviar">Enviar</button>
                    </form>
                    <<h1><?php // echo base_url(); ?></h1> 
                    
                </div>
            </div>
        </div> 
    </body>
</html>