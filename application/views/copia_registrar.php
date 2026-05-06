<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Constancia de trabajo y Nominas</title>

        <!-- CSS -->
        <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">-->
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css')?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/form-elements.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style2.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/stilos.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>">
        <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                   

<div class="row">
                        <div class="col-sm-4 col-sm-offset-4 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>Registrar nuevo usuario</h3>
                                    <p><b>Ingresa tus datos:</b></p>
                                </div>
                                <div class="form-top-right">
                        <i class="fa fa-pencil"></i>
                                    
                                </div>
                            </div>
                            <div class="form-bottom">
                                <?php echo form_open('blog/verificarus');?>

                                    <div class="form-group">
                                        <label class="sr-only" for="form-cedula">Cedula</label>
                                        <input type="text" name="cedula" placeholder="Número de Cedula..." class="form-username form-control" id="form-username" required="required">
                                    </div>
                                    <div class="form-group">
                                        <select name="tipoper" class="form-control" required="required">
                                            <option value="" disabled selected>Tipo de Personal:</option>
                                            <option value="01">Docente</option>
                                            <option value="02">Administrativo</option>
                                            <option value="03">Obrero</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn">Continuar</button>
                                
                                </form>
                            </div>
                            <div class="social-login-buttons">
                    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
                    <p class="text-success"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje2'); ?></b></p>

                                <a class="btn btn-link-2" href="<?php echo site_url('blog/') ?>">
                                    <i class="fa fa-reply"></i> Volver
                                </a>

                            </div>
                    </div>
                </div>


        <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js')?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.backstretch.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/scripts.js')?>"></script>

    </body>

</html>