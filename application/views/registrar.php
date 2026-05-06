<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar Usuario | Constancia de Trabajo y Nóminas</title>
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
            <img src="<?php echo base_url('assets/ico/logo1.png')?>" alt="Logo" class="animated fadeIn">
        </div>

        <h1 class="login-title">Crear Cuenta</h1>
        <p class="login-subtitle">Ingresa tus datos para verificar tu usuario</p>

        <?php echo form_open('blog/verificarus', ['class' => 'main-login-form']);?>
            <div class="form-group">
                <label for="cedula">Cédula de Identidad</label>
                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ej: 12345678" required>
            </div>
            
            <div class="form-group">
                <label for="tipoper">Tipo de Personal</label>
                <select name="tipoper" id="tipoper" class="form-control" required>
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="01">Docente</option>
                    <option value="02">Administrativo</option>
                    <option value="03">Obrero</option>
                </select>
            </div>

            <button type="submit" class="login-button">
                <span>Continuar</span>
                <i class="fa fa-chevron-right"></i>
            </button>
        <?php echo form_close(); ?>

        <div class="footer-links">
            <p><a href="<?php echo site_url('blog/') ?>"><i class="fa fa-arrow-left"></i> Volver al inicio de sesión</a></p>
        </div>

        <?php if (validation_errors() || $this->session->flashdata('mensaje') || $this->session->flashdata('mensaje2')): ?>
            <div class="error-message animated fadeIn">
                <?php 
                    echo validation_errors(); 
                    echo $this->session->flashdata('mensaje'); 
                    echo $this->session->flashdata('mensaje2'); 
                ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <img src="<?php echo base_url('source/img/pie_dire.png')?>" alt="Footer Logo"><br>
        <span>&copy; <?php echo date("Y"); ?> UNEFM | <?php echo date("d/m/Y"); ?></span>
    </footer>

</body>
</html>