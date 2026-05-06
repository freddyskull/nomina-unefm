<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="utf-8">
   <!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
   <title>Constancia de trabajo y Nominas</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <script src="<?php echo base_url('dist/js/jquery.min.js')?>"></script>
   <script src="<?php echo base_url('dist/js/bootstrap.min.js')?>"></script> 
   <!-- <link href="dist/css/bootstrap.css" rel="stylesheet">  -->
   <link href="<?php echo base_url('dist/css/resboot.css')?>" rel="stylesheet"> 
   <link rel="stylesheet" href="<?php echo base_url('assets/css/stilos.css')?>">
   <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css')?>">
   <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>">

    <!--<link rel="stylesheet" href="<?php echo base_url('assets/css/form-elements.css')?>">

   <link href="dist/css/bootstrap-theme.css" rel="stylesheet">  
   <link href="dist/css/theme.css" rel="stylesheet">  -->
   <link href="<?php echo base_url('dist/css/main.css')?>" rel="stylesheet" >
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-28807146-1', 'auto');
  ga('send', 'pageview');
</script>

<div class="header-container">
    <header class="wrapper clearfix">
    <p style="margin:10px 2px">
    <img src="<?php echo base_url('source/img/UNEFM40blanco.jpg')?>"  class='img-responsive' style="max-height:80px"></p>
   <br><br><br>
  </header>
</div>
<div class="clear" style=" height:5px; margin:-86px auto 0px auto"></div>
<div class="main-container">
  <div style="height: 92px" ></div>
  <div class="main wrapper clearfix">
</div></div>


<!-- Where all the magic happens -->
<!-- LOGIN FORM -->
<div class="text-center" style="padding:50px 0">
  <div class="logo">
    <h1 class="animated zoomIn" style="color: #6d6d6d" >Registrar nuevo usuario</h1>
    <h3 style="color: #6d6d6d" > Ingresa tus datos:</h3> 
    </div>                               
                            

  <!-- Main Form -->
  <div class="login-form-1">
      <?php echo form_open('blog/registrar2');?>
      <div class="login-form-main-message"></div>
      <div class="main-login-form">
        <div class="login-group">


                <?php foreach ($datosemp as $key => $value):?>

                    <div class="form-group">
                        <p> <b>Cedula:<br></b> <?php echo $value[1]; ?></p>
                        <p><b>Nombre:<br></b> <?php echo $value[2]; ?></p>
                        <p><b>Apellido:<br></b> <?php echo $value[3]; ?></p>
                        <p><b>Direccion:<br></b> <?php echo $value[4]; ?></p>
                        <input type="hidden" name="tipoper" value="<?php echo $value[0]; ?>"  class="form-username form-control" id="form-username">
                        <input type="hidden" name="cedula" value="<?php echo $value[1]; ?>"  class="form-username form-control" id="form-username">
                    </div>
        

                <?php endforeach ?>                             
        </div><br>
    <div class="main-login-form">
        <div class="login-group">
            <div class="form-group">
                <label for="lg_username" class="sr-only">usuario</label>
                <input type="text" class="form-control" id="lg_username" name="us" placeholder="Ingrese nombre de usuario:" required="required" maxlength='15'>
            </div>

            <div class="form-group">
                <label for="lg_password" class="sr-only">Clave</label>
                <input type="password" class="form-control" id="lg_password" name="clave" placeholder="Ingrese contraseña o clave:" required="required" maxlength='20'>
            </div>

            <div class="form-group">
                <label for="lg_password" class="sr-only">Clave2</label>
                <input type="password" class="form-control" id="lg_password" name="clave2" placeholder="Repita contraseña o clave:" required="required" maxlength='20'>
            </div>

            <div class="form-group">
                <label for="lg_password" class="sr-only">Email</label>
                <input type="email" class="form-control" id="lg_password" name="email" placeholder="Correo (Email):" required="required" maxlength='200'>
            </div>
            <div><br><p align="left"> <b style="color:black">Preguntas y Respuestas de seguridad:<br></b> </div>
                        <div class="form-group">
                <label for="lg_username" class="sr-only">pregunta1</label>
                <input type="text" class="form-control" id="lg_username" name="preg" placeholder="Primera Pregunta:" required="required" maxlength='100'>
            </div>
                        <div class="form-group">
                <label for="lg_username" class="sr-only">respuesta</label>
                <input type="text" class="form-control" id="lg_username" name="resp" placeholder="Respuesta:" required="required" maxlength='100'>
            </div>
                        <div class="form-group">
                <label for="lg_username" class="sr-only">pregunta2</label>
                <input type="text" class="form-control" id="lg_username" name="preg2" placeholder="Segunta Pregunta:" required="required" maxlength='100'>
            </div>
                        <div class="form-group">
                <label for="lg_username" class="sr-only">respuesta2</label>
                <input type="text" class="form-control" id="lg_username" name="resp2" placeholder="Respuesta:" required="required" maxlength='100'>
            </div>
        </div>
        <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
        </form>
      </div>
     
            <br><div class="social-login-buttons">
                <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>

                <br><a class="btn btn-link-2" href="<?php echo site_url('blog/') ?>"><i class="fa fa-reply"></i> Volver</a>

            </div>




  </div>
  <!-- end:Main Form -->
</div>
<br><br><br><br>
    </div> <!-- #main -->
    </div> <!-- #main-container -->

<footer style="text-align:right">

  <img src="<?php echo base_url('source/img/pie_dire.png')?>" style="padding: 1px 15px;"><br> 
  <span style="color: #00008b; background-color: rgba(160, 164, 202, 0.34); padding: 0 5px; margin-right: 3px;"> <?php echo date("d/m/Y") ; ?> </span>
</footer>
</body>
</html>