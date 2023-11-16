<head>
    <!-- Enlaces CDN de Bootstrap CSS y JavaScript -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plungins/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        /* Agregar estilos personalizados */
        .navbar-nav .nav-link {
            color: #e4ecfa;
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light " style="background-color: #e4ecfa;" >
    <div class="container">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a style="color: #13237b;  " class="nav-link" href="<?php echo site_url('automatizar'); ?>">Automatizado</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" >
                    <a style="color: #13237b;  " class="nav-link" href="<?php echo site_url('cactualizar'); ?>">Actualizaciones</a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a style="color: #13237b;  " class="nav-item" href="<?php echo site_url('auth/cerrar_sesion'); ?>">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>





