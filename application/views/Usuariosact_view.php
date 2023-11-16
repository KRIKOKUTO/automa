<!DOCTYPE html>
<html>
<head>
    <?php //$navbar_data['title'] = 'Barra de Navegación';
        //$this->load->view('navbar', $navbar_data);?>
    <title>Foas</title>
    <meta charset="UTF-8">
    <title>Usuarios - Actividades</title>
    <!-- Agrega la hoja de estilo de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- Agrega la biblioteca jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Agrega la biblioteca DataTables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializa DataTable en tu tabla con ID 'miTabla'
            $('#miTabla').DataTable();
        });
    </script>
</head>
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
<body >

<h1>Usuarios - Actividades</h1>

<table id="miTabla">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th> <!-- Columna adicional para acciones -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filas as $fila): ?>
            <tr>
                <td><?= $fila->id ?></td>
                <td><?= $fila->usuario ?></td>
                <td><?= $fila->rol ?></td>
                <td><?= $fila->estado ?></td>
                <td>
                    <!-- Agrega un formulario para cambiar el estado -->
                    <form action="<?= base_url('usuariosact/cambiar_estado') ?>" method="post">
                        <input type="hidden" name="usuario_id" value="<?= $fila->id ?>">
                        <select name="nuevo_estado">
                            <option value="activo" <?= ($fila->estado == 'activo') ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= ($fila->estado == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                        <button type="submit">Cambiar Estado</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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
