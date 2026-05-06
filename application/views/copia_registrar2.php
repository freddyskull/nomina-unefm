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
                                <?php echo form_open('blog/registrar2');?>
                            <?php foreach ($datosemp as $key => $value):?>

                                    <div class="form-group">
                                        <p style="color: white;"> <b>Cedula:</b> <?php echo $value[1]; ?></p>
                                        <p style="color: white;"><b>Nombre:</b> <?php echo $value[2]; ?></p>
                                        <p style="color: white;"><b>Apellido:</b> <?php echo $value[3]; ?></p>
                                        <p style="color: white;"><b>Direccion:</b> <?php echo $value[4]; ?></p>
                                        <input type="hidden" name="tipoper" value="<?php echo $value[0]; ?>"  class="form-username form-control" id="form-username">
                                        <input type="hidden" name="cedula" value="<?php echo $value[1]; ?>"  class="form-username form-control" id="form-username">

                            <?php endforeach ?>
                                        
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="us" placeholder="Ingrese nombre de usuario:" class="form-username form-control" id="form-username" required="required" maxlength='15'>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="clave" placeholder="Ingrese contraseña o clave:" class="form-username form-control" id="form-username" required="required" maxlength='12'>
                                    </div>  

                                    <div class="form-group">
                                        <input type="password" name="clave2" placeholder="Repita contraseña o clave:" class="form-username form-control" id="form-username" matc required="required" maxlength='12'>
                                    </div>  

                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Correo (Email):" class="form-username form-control" id="form-username" required="required" maxlength='25'>
                                    </div>
                                    <button type="submit" class="btn">Continuar</button>
                                
                                </form>
                            </div>
                            <div class="social-login-buttons">
                    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>

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