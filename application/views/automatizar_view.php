<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo Excel</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/plungins/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        table {
            border-collapse: collapse;
            
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            text-align: center;
            padding: 8px;
        }

        .center {
            
            align-items: center;
            justify-content: center;
        }
        
        
        
        .transparent-box {
            border: 1px solid rgba(0, 0, 0, 0.1); 
            background-color: rgba(0, 0, 0, 0.1); 
            color: #000; 
            padding: 10px; 
            margin-bottom: 15px; 
        }
        .transparent-box1 {
            border: 1px solid rgba(0, 0, 0, 0.1); 
            background-color: rgba(0, 0, 0, 0.1); 
            color: #000; 
            padding: 10px; 
            margin-bottom: 15px; 
            max-width: 400px;
        }
        .transparent-box_ {
            border: 1px solid #000; 
            background-color: rgba(0, 0, 0, 0); 
            color: #000;
            padding: 10px;
            margin-bottom: 15px;
            width: 100px;
        }
        footer {
        
        bottom: 0;
        
        background-color: #e4ecfa; 
        color: white;
        padding: 10px;
        
        }
        body {
            width: 100%
            min-height: 100vh;
        }
        main {
        
        }
        th {
        background-color: #21A366;
        color: white; 
        }
        .btn-orange {
        background-color: #ec8633;
        border-color: #ec8633;
        color: black;
        }
        .custom-dropdown .form-control {
            background-color: white;
            color: #333; 
            border: 1px solid #ced4da; 
        }
    
    </style>
    <script>
        
        $(document).ready(function() {
            var archivoInput = $('.archivo');
            var submitButton = $('#submitButton');
            
            archivoInput.change(function() {
                
                submitButton.prop('disabled', archivoInput.get(0).files.length === 0);
            });
            
            $('.btn-generar').on('click', function() {
                
                var fecha = $(this).data('id');
                console.log(fecha);
                $(this).hide();
                $('.aviso[data-id="' + fecha + '"]').show();
                
                $.ajax({
                    url: '<?= base_url('automatizar/automatizado') ?>',
                    type: 'POST',
                    data: { fecha: fecha },
                    success: function(response) {
                        
                        console.log(response);
                    },
                    error: function(error) {
                        
                        console.error(error);
                    }
                });

                
                console.log("Datos enviados:", { fecha: fecha });

            });
            $('.btn-subir-nuevo').on('click', function() {
                
                var fecha = $(this).data('id');
                console.log("Subir Nuevo clic en la fecha:", fecha);
            });
            $('.btn2-generar').on('click', function() {
                
                fecha2 = $(this).data('id');
                $(this).hide();
                $('.aviso2[data-id="' + fecha2 + '"]').show();
                $.ajax({
                    url: '<?= base_url('automatizar/geozona') ?>',
                    type: 'POST',
                    data: { fecha1: fecha2 },
                    success: function(response) {
                        
                        console.log(response);
                    },
                    error: function(error) {
                        
                        console.error(error);
                    }
                });

                
                console.log("Datos enviados:", { fecha: fecha });

            });
            $('.btn-subir-nuevo2').on('click', function() {
                
                var fecha = $(this).data('id');
                console.log("Subir Nuevo clic en la fecha:", fecha);
            });
        });
    
        $(document).ready(function() {
            var fecha;
            console.log("oña jiji");
            console.log($(this).data('id'));
            
        });
    
        $(document).ready(function(){
            
            $("#btnActualizar").on("click", function(){
                
                $("#loading-indicator").show();

                
                /*$.ajax({
                    url: "automatizar/actualizar_vista",
                    type: "GET",
                    success: function(data){
                        
                        $("body").html(data);

                        
                        $("#loading-indicator").hide();
                        $('.aviso[data-id="' + fecha + '"]').hide();
                        
                        
                    },
                    error: function(error){
                        console.log("Error al actualizar la vista: " + error);
                        
                        $("#loading-indicator").hide();
                        
                    }
                });*/
            });
        });
    </script>
    <style>
        #loading-indicator {
            display: none;
            text-align: center;
            margin: 20px;
        }
        .formulario-izquierda {
        
    }
        
    </style>

</head>
<body>
<br>
<?php if ($rol == 'planeacion'): ?>
<div class="container">
    <div class="formulario-izquierda" style="float: right; max-weight: 500px;">
    
    <div style="padding: 100px;">
    </div>
    
    <?php echo form_open_multipart('automatizar/mes'); ?>
            <label for="mes_">Seleccionar mes:</label>
            <select name="mes_" id="mes_" class="form-group custom-dropdown">
                <?php
                // Lista de meses
                $meses_ = array(
                    'enero' => 'Enero',
                    'febrero' => 'Febrero',
                    'marzo' => 'Marzo',
                    'abril' => 'Abril',
                    'mayo' => 'Mayo',
                    'junio' => 'Junio',
                    'julio' => 'Julio',
                    'agosto' => 'Agosto',
                    'septiembre' => 'Septiembre',
                    'octubre' => 'Octubre',
                    'noviembre' => 'Noviembre',
                    'diciembre' => 'Diciembre'
                );

                // Itera meses y crea lista desplegable
                foreach ($meses_ as $key => $mes_) {
                    echo '<option value="' . $key . '">' . $mes_ . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Mostrar mes" class="btn btn-primary ">
        <?php echo form_close(); ?>

    </div>

    <div class="formulario-derecha" style="float: left; max-weight: 500px;" >
        <?php echo form_open_multipart('automatizar/actualizarvista'); ?>
            <button id="btnActualizar" class="btn btn-primary">Actualizar tabla</button>
        <?php echo form_close(); ?>
        <div id="loading-indicator">
            <p>Cargando...</p>
        </div>
        
        <div class="transparent-box1">
            <?php echo form_open_multipart('automatizar/do_upload', array('id' => 'myForm')); ?>
                <!-- -->
                <input type="hidden" name="parametro_adicional" value="valor_del_parametro">

                <label for="archivo">Subir nuevo:</label>
                <input type="file" name="archivo" id="archivo" class="archivo" accept=".xlsx">
                <br>
                <label for="mes">Seleccionar mes:</label>
                <select name="mes" id="mes">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select><br>
                <label for="ano">Ejercicio: </label>
                <select name="ano" id="ano">
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                    <option value="2036">2036</option>
                    <option value="2037">2037</option>
                    <option value="2038">2038</option>
                </select>
                <div style="text-align: center">
                    <input type="submit" value="Subir Archivo" class="btn btn-primary" id="submitButton" disabled>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php endif; ?>
    <div >
        <table border="1" class="container mt-5" >
        <tr>
            <th>Mes</th>
            <th>Archivo Beneficiarios</th>
            <th>iGTO</th>
            <th>georreferencias <br>
            y zonas impulso</th>
            <th>Status</th>
        </tr>

        <?php foreach ($filas as $fila): ?>
            <tr>
                <td><?= $fila->mes ?></td>
                <td><?php echo '<a href="' . base_url($fila->beneficiarios) . '"download="'.'Beneficiarios_'.$fila->fecha.'">'.$fila->beneficiarios.'</a>'; ?> </td>
                <td>
                <?php if ($fila->igto === null): ?>
                    <?php if ($rol === 'planeacion'): ?>
                    <input type="button" value="Generar" class="btn-generar" style="background-color:  #21A366; border-radius: 5px; border: none; color: white;" data-id="<?= $fila->fecha ?>" >
                    
                    <br><?= $fila->igto ?>
                    <p style="display:none;" class="aviso" data-id="<?= $fila->fecha ?>">presiona actualizar para ver los cambios</p>
                    <br>
                    <?php else: ?>
                        <p>Aun no generado</p>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <br><?php echo '<a href="' . base_url($fila->igto) . '"download="'.'igto_'.$fila->fecha.'">'.'iGTO_'.$fila->fecha.'</a>'; ?>
                    <p style="display:none;" class="aviso" data-id="<?= $fila->fecha ?>">presiona actualizar para ver los cambios</p>
                    <br><br>
                    <?php echo form_open_multipart('automatizar/do_uploadiGto'); $fecha = $fila->fecha; ?>

                    <!-- fecha oculta -->
                    <input type="hidden" name="fecha" value="<?php echo $fecha ?>">

                    <?php if ($rol == 'planeacion'): ?>
                        <div class="transparent-box">
                            <label for="archivo"><b>Subir modificación:</b></label><br>
                            <input type="file" name="archivo" id="archivo" accept=".xlsx">
                            <br>
                            <input type="submit" value="Subir Archivo" >
                        </div>
                        
                    <?php echo '<a href="' . base_url('Foliostxt/folios'.$fila->fecha.'.txt') . '"download="'.'folios'.$fila->fecha.'.txt">'.' Descargar folios</a>'; ?>
                    <?php endif; ?>
                    
                    <?php echo form_close(); ?>
                <?php endif; ?>
                </td  >

                <td >
                
                    <?php if ($fila->igto_ === null): ?>
                    
                    <p style="display:none;" class="aviso2" data-id="<?= $fila->fecha ?>">presiona actualizar para ver los cambios</p>
                    
                    <?php echo form_open_multipart('automatizar/geozona'); ?>

                    <!-- georreferencias y zonas impulso -->
                        <?php if ($fila->igto !== null): ?>
                        <input type="hidden" name="fecha_" id='fecha_' value="<?php echo $fila->fecha; ?>">

                        <label for="archivo"><b>Archivo con <br>georreferencias y zonas impulso:</b></label><br>
                        <input type="file" name="archivo" id="archivo" accept=".xlsx">
                        <br>
                        <input type="submit" value="Subir Archivo">
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert" style="width: 100%; height: 100%;">
                                <img src="<?php  echo base_url('6121171.png'); ?>" alt="Icono de advertencia" width="20" height="20">
                                <i class="bi bi-exclamation-triangle-fill"></i> Falta generar iGTO
                            </div>
                        <?php endif; ?>
                    <?php echo form_close(); ?>
                    

                    <?php else: ?>
                    <br><?php echo '<a href="' . base_url($fila->igto_) . '"download="'.'iGTO+_'.$fila->fecha.'">'.'iGTO+_'.$fila->fecha.'</a>'; //<?= $fila->igto_ ?> 
                    <p style="display:none;" class="aviso2" data-id="<?= $fila->fecha ?>">presiona actualizar para ver los cambios</p>
                    <br><br>
                    <?php echo form_open_multipart('automatizar/do_uploadiGto_'); $fecha = $fila->fecha; ?>

                    <!-- Fecha oculta -->
                    <input type="hidden" name="fecha" value="<?php echo $fecha ?>">

                    
                    <div class="transparent-box">
                        <label for="archivo"><b>Subir modificación:</b></label><br>
                        <input type="file" name="archivo" id="archivo" accept=".xlsx">
                        <br>
                        <input type="submit" value="Subir Archivo">
                    </div>
                    <?php echo form_close(); ?>

                    <?php endif; ?>
                    
                    
                </td>
                        
                <td>
                <?php if ($fila->beneficiarios !== null): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle"></i> Beneficiarios subidos
                        </div>
                <?php else: ?>
                    <div class="transparent-box">
                        <i class="bi bi-check-circle"></i> Beneficiarios vacios
                    </div>
                <?php endif; ?>

                <?php if ($fila->igto !== null): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle"></i> Plantilla igto Generada
                        </div>
                <?php else: ?>
                    <div class="transparent-box">
                        <i class="bi bi-check-circle"></i> Plantilla igto sin generar
                    </div>
                <?php endif; ?>

                <?php if ($fila->igto_ !== null): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle"></i> Georreferencias y zonas impulso llenadas
                        </div>
                <?php else: ?>
                    <div class="transparent-box">
                        <i class="bi bi-check-circle"></i> Georreferencias y zonas impulso sin llenar
                    </div>
                <?php endif; ?>
                
                </td>
            </tr>
        <?php endforeach; ?>

    </table >
    
        
        
    <?php if (is_array($filas) && isset($filas[0])): ?>
    <div style="padding: 120px;">

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
    <?php else: ?>
        <footer style="position: absolute; width: 100%;">
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
    <?php endif; ?>
</body>

</html>