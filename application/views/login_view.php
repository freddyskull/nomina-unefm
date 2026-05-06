<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión | Constancia de Trabajo y Nóminas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login_modern.css')?>">
    
    <script src="<?php echo base_url('dist/js/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('dist/js/bootstrap.min.js')?>"></script>
</head>
<body>

    <div class="login-container">
        <div class="header-logo">
            <img src="<?php echo base_url('assets/ico/logo1.png')?>" alt="Logo" class="animated zoomIn">
        </div>

        <h1 class="login-title">Bienvenido</h1>
        <p class="login-subtitle">Gestión de Constancias y Nóminas</p>

        <?php echo form_open('blog/ingresar', ['class' => 'main-login-form']);?>
            <div class="form-group">
                <label for="lg_username">Usuario</label>
                <input type="text" class="form-control" id="lg_username" name="usuario" placeholder="Ingresa tu usuario" required>
            </div>
            
            <div class="form-group">
                <label for="lg_password">Contraseña</label>
                <input type="password" class="form-control" id="lg_password" name="contra" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-button">
                <span>Ingresar</span>
                <i class="fa fa-chevron-right"></i>
            </button>
        <?php echo form_close(); ?>

        <div class="footer-links">
            <p><a href="#" data-toggle="modal" data-target="#myModal">¿Olvidaste tu contraseña?</a></p>
            <p>¿No tienes cuenta? <a href="<?php echo site_url('blog/registrar') ?>">Regístrate aquí</a></p>
        </div>

        <?php if (validation_errors() || $this->session->flashdata('mensaje')): ?>
            <div class="error-message animated shake">
                <?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <img src="<?php echo base_url('source/img/pie_dire.png')?>" alt="Footer Logo"><br>
        <span>&copy; <?php echo date("Y"); ?> UNEFM | <?php echo date("d/m/Y"); ?></span>
    </footer>

    <!-- Modal for recovery info -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Olvidaste tu contraseña?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>La información de usuario y clave se debe solicitar <b>personalmente</b> en el Departamento de Registro y Control, con cédula en mano.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
