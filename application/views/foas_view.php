<!DOCTYPE html>
<html>
<head>
    <?php //$navbar_data['title'] = 'Barra de Navegación';
        //$this->load->view('navbar', $navbar_data);?>
    <title>Foas</title>
</head>
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
</style>
<body >
    <h1>Contenido de la Tabla FOAS</h1>
    <div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Folio</th>
                    <th>Folio Obra Accion</th>
                    <th>Latitutd</th>
                    <th>Longitud</th>
                    <th>id Zona impuso</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filas as $fila): ?>
                    <tr>
                        <td><?php echo $fila->folio; ?></td>
                        <td><?php echo $fila->foa; ?></td>
                        <td><?php echo $fila->lat; ?></td>
                        <td><?php echo $fila->lon; ?></td>
                        <td><?php echo $fila->zon; ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    

    <?php if (is_array($filas) && isset($filas[1])): ?>
    <div style="padding: 25px;">

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
