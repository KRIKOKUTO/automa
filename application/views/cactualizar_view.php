<!DOCTYPE html>
<html>
<head>
    <title>Subir Archivo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
        flex: 1;
        }
        #container {
            margin: auto;
            max-width: 500px;
            width: 45%; 
            display: inline-block;
            vertical-align: top;
            margin: 10px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            height: 250px;
        }
        
        body {
            
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #container-wrapper {
            text-align: center;
        }

    </style>
    <script>

        $(document).ready(function() {
            var archivoInput = $('.archivo');
            var submitButton = $('#submitButton');
            
            archivoInput.change(function() {
                
                submitButton.prop('disabled', archivoInput.get(0).files.length === 0);
            });
            

            var dropdown = $('<select>').attr('name', 'opciones').attr('id', 'opciones');
            dropdown.append($('<option>').text('cids').val('ids'));
            dropdown.append($('<option>').text('metas').val('cmetas'));
            dropdown.append($('<option>').text('montos').val('cmontos'));
            dropdown.append($('<option>').text('Todos los catalogos').val('varios'));
            dropdown.append($('<option>').text('cTiposObrasAcciones').val('cTiposObrasAcciones'));
            dropdown.append($('<option>').text('cCategorias').val('cCategorias'));
            dropdown.append($('<option>').text('cSubcategorias').val('cSubCategorias'));
            dropdown.append($('<option>').text('cEnfoques').val('cEnfoques')); 
            dropdown.append($('<option>').text('cTipos').val('cTipos'));
            dropdown.append($('<option>').text('cStatusObrasAcciones').val('cStatusObrasAcciones'));
            dropdown.append($('<option>').text('cStatusAvance').val('cStatusAvance'));
            dropdown.append($('<option>').text('cDependencias').val('cDependencias'));
            dropdown.append($('<option>').text('cMunicipios').val('cMunicipios'));
            dropdown.append($('<option>').text('cEstados').val('cEstados'));
            dropdown.append($('<option>').text('cLocalidades').val('cLocalidades_'));
            dropdown.append($('<option>').text('cZonasImpulso').val('cZonasImpulso'));
            dropdown.append($('<option>').text('cCentrosTrabajo').val('cCentrosTrabajo'));
            dropdown.append($('<option>').text('cTiposAsentamientos').val('cTiposAsentamientos'));
            dropdown.append($('<option>').text('cTiposVialidades').val('cTiposVialidades'));
            dropdown.append($('<option>').text('cSituaciones').val('cSituaciones'));
            dropdown.append($('<option>').text('vwmd_ProgramaSectorial').val('vwmd_ProgramaSectorial'));
            dropdown.append($('<option>').text('cAgendas').val('38.- cAgendas'));
            dropdown.append($('<option>').text('cTiposBeneficiarios').val('cTiposBeneficiarios'));
            dropdown.append($('<option>').text('catPais').val('catPais'));
            dropdown.append($('<option>').text('cCalificacionesCualitativas').val('cCalificacionesCualitativas'));
            dropdown.append($('<option>').text('cCodigosSepomex').val('cCodigosSepomex'));
            dropdown.append($('<option>').text('cEjes').val('cEjes'));
            dropdown.append($('<option>').text('cEjesEstrategicos').val('cEjesEstrategicos'));
            dropdown.append($('<option>').text('cEstadosCivil').val('cEstadosCivil'));
            dropdown.append($('<option>').text('cEstrategias_PG').val('cEstrategias_PG'));
            dropdown.append($('<option>').text('cGrupoCategorias').val('cGrupoCategorias'));
            dropdown.append($('<option>').text('cMeses').val('cMeses'));
            dropdown.append($('<option>').text('cModalidadesContratacion').val('cModalidadesContratacion'));
            dropdown.append($('<option>').text('cObjetivos_PG').val('cObjetivos_PG'));
            dropdown.append($('<option>').text('cTiposAgendas').val('cTiposAgendas'));
            dropdown.append($('<option>').text('cTiposConcurrencias').val('cTiposConcurrencias'));
            dropdown.append($('<option>').text('cTiposEnfoques').val('cTiposEnfoques'));
            dropdown.append($('<option>').text('cTiposObrasAccionesG1').val('cTiposObrasAccionesG1'));

            var filaInicialDropdown = $('<select>').attr('name', 'fila_inicial').attr('id', 'fila_inicial');
            for (var i = 1; i <= 50; i++) {
                filaInicialDropdown.append($('<option>').text(i).val(i));
            }

            filaInicialDropdown.val('7');

            $('#archivo').after('<br>'); // Agregar un salto de línea
            $('#archivo').after(dropdown); // Agregar la lista desplegable "opciones"
            $('#archivo').after('Selecciona una opción: ');
            $('#archivo').after('<br>');

            $('#archivo').after('<br>');
            $('#archivo').after(filaInicialDropdown); 
            $('#archivo').after('Selecciona una fila inicial: ');
            $('#archivo').after('<br>');
            



            $('#resetear-form').submit(function(event) {
                
                event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

                // Obtener los valores de los campos del formulario
                var selectedYear = $('#ano').val();
                var inputNumber = $('#numero').val();

                // Realizar acciones con los valores, por ejemplo, enviarlos al servidor
                console.log('Año seleccionado: ' + selectedYear);
                console.log('Número ingresado: ' + inputNumber);

                // Puedes realizar una llamada AJAX para enviar los datos al servidor aquí

                // Restablecer los campos del formulario si es necesario
                $('#ano').val('');
                $('#numero').val('');
            });
            
        });
    </script>
</head>

<body>
<div id="container-wrapper">

    <div id="container">
        <h2>Resetear Folios obra accion</h2>
    <?php echo form_open_multipart('automatizar/resetfoa'); ?>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" name="pass" id="pass" required>
        </div>
        <div style="text-align: center;">
            <input type="submit" value="Resetear FOA's" class="btn btn-primary" id="resetButton">
        </div>
    <?php echo form_close(); ?>
    </div>
    <div id="container">
        <h2>Ver folios</h2>
        <div style="padding: 25px;">
        </div>
        <?php echo form_open_multipart('automatizar/verfoas'); ?>
            <div style="text-align: center;">
                <input type="submit" value="Ver FOA's" class="btn btn-primary" id="resetButton">
            </div>
        <?php echo form_close(); ?>
    </div>
    <div id="container">
        <h2>Borrar archivos</h2>
        <?php echo form_open_multipart('automatizar/borrarArch'); ?>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="pass" id="pass" required>
            </div>
            <div style="text-align: center;">
                <input type="submit" value="Borrar" class="btn btn-primary" id="resetButton">
            </div>
        <?php echo form_close(); ?>
    </div>
    <div id="container">
            <h2>Actualización de catálogos</h2>
            <form action="<?php echo site_url('cactualizar/do_upload'); ?>" method="post" enctype="multipart/form-data" id="miFormulario">
                <input type="file" name="archivo" id="archivo" class="archivo" accept=".xlsx" >
                <br>
                <div style="text-align: center;">
                    <input type="submit" value="Subir Archivo" name="submit" class="btn btn-primary" id="submitButton" disabled>
                </div>
            </form>
        </div>
</div>

    
    <div style="padding: 80px;">
    </div>
</body>
    <footer >
        
        <div>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php  echo base_url('logo-gto.png'); ?>" alt="Logo" width="80" height="60">
                </div>
                <div class="col-md-6 text-md-right">
                    
                </div>
            </div>
        </div>
    </footer>
</html>


