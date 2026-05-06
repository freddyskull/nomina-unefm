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
    <h1 class="animated zoomIn" style="color: #6d6d6d">Recuperar contraseña</h1>
    <h3 style="color: #6d6d6d" > Responde las preguntas de seguridad:</h3> 
    </div>                               
                            

  <!-- Main Form -->
  <div class="login-form-1">
      <?php echo form_open('blog/recuperarus2');?>
      <div class="login-form-main-message"></div>
      
                <?php foreach ($preguntas as $key => $value):?>

    <div class="main-login-form">
        <div class="login-group">
            <div class="form-group">
            <?php if ($value[0]==null || $value[1]==null){ ?>
                                   <p style="color:black">Usted no ha llenado la información de <b>preguntas y respuestas</b> necesarias para la recuperación de su usuario y contraseña. Usted Debe solicitar esta información <b>Personalmente</b> en el Departamento de Registro y Control, con cédula en mano.</p>

                                     </div>

  <!-- end:Main Form -->
</div>
                <br><a class="btn btn-link-2" href="<?php echo site_url('blog/') ?>"><i class="fa fa-reply"></i> Volver</a>
<br><br><br><br>
    </div> <!-- #main -->
    </div> <!-- #main-container -->

<footer style="text-align:right">

  <img src="<?php echo base_url('source/img/pie_dire.png')?>" style="padding: 1px 15px;"><br> 
  <span style="color: #00008b; background-color: rgba(160, 164, 202, 0.34); padding: 0 5px; margin-right: 3px;"> <?php echo date("d/m/Y") ; ?> </span>
</footer>
</body>
</html>
            <?php }else{ ?>
                <input type="hidden" name="tipoper" value="<?php echo $value[3]; ?>"  class="form-username form-control" id="form-username">
                <input type="hidden" name="cedula" value="<?php echo $value[2]; ?>"  class="form-username form-control" id="form-username">
                <p style="color:black"> <b>Primera pregunta:<br></b> <?php echo $value[0]; ?></p>

                <label for="respuesta" class="sr-only">respuesta</label>
                <input type="text" class="form-control" id="respuesta" name="respuesta" placeholder="Ingrese su respuesta:" required="required" maxlength='100'><br>
            </div>

            <div class="form-group"><br>
                <p style="color:black"><b>Segunta pregunta:<br></b> <?php echo $value[1]; ?></p>                
                <label for="respuesta2" class="sr-only">respuesta2</label>
                <input type="text" class="form-control" id="respuesta2" name="respuesta2" placeholder="Ingrese su respuesta:" required="required" maxlength='100'>
            </div>

        </div>
        <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
        </form>
      </div>
     
            <br><div class="social-login-buttons">
                <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>

                <br><a class="btn btn-link-2" href="<?php echo site_url('blog/') ?>"><i class="fa fa-reply"></i> Volver</a>

            </div>

            <?php } ?>


                <?php endforeach ?>
                             

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