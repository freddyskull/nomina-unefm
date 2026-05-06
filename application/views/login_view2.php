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
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">


    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1 class="animated zoomIn">Contancias de Trabajo y Nominas</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Iniciar Sesión</h3>
                            		<p>Ingresa tu usuario y clave para entrar:</p>
                        		</div>
                        		<div class="form-top-right">
                        <img src="<?php echo base_url('assets/ico/logob.png')?>" WIDTH=60 HEIGHT=90 class="animated infinite pulse">
                        			
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <?php echo form_open('blog/ingresar');?>

			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Usuario</label>
			                        	<input type="text" name="usuario" placeholder="Usuario..." class="form-username form-control" id="form-username" required="required">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Clave</label>
			                        	<input type="password" name="contra" placeholder="Clave..." class="form-password form-control" id="form-password" required="required">
			                        </div>

			                        <button type="submit" class="btn">Entrar</button>
                                   <br><br><p style="color: white;">¿Olvido su contraseña? pulse <a href="" data-toggle="modal" data-target="#myModal"><strong><b>aquí<b></strong></a>
			                    </form>
		                    </div>
                    </div>
                </div>
                    <div class="center">
                    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	<h3>Si no tienes usuario, puedes registarte:</h3>
                        	<div class="social-login-buttons">

	                        	<a class="btn btn-link-2" href="<?php echo site_url('blog/registrar') ?>">
	                        		<i class="fa fa-user-plus"></i> Registrarte
	                        	</a>


                              <!-- Modal -->
                              <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">¿Olvido su contraseña?</h4>
                                    </div>
                                    <div class="modal-body">
                                      <p>La información de usuario y clave se debe solicitar <b>Personalmente</b> <br>en la oficina de informática, con cédula en mano.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                  
                                </div>
                              </div>
                              





                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js')?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.backstretch.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>