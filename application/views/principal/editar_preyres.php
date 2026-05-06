
 <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Cambiar preguntas  y respuestas de seguridad</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
<span> Se Informa al Personal Docente, Administrativo y Obrero, adscrito a nuestra Casa de Estudios,  que está disponible la funcion para recuperar usuario y contraseña mediante el link: <u><b>¿olvido su contraseña?</b></u> en la ventana de Inicio de Sesion,  para ello es necesario llenar el siguiente formulario. </span> <br><br><br>  

<?php echo form_open('blog/editar_preyres2');?>

  <?php foreach ($preyres as $key => $value): ?>


    <center>
    <div style="    margin: 10px; width: 500px;">
        <b>Primera pregunta: </b><br>

          <input type="text" class="form-control" id="lg_password" name="pregunta" value="<?php echo $value['pregunta']; ?>" required="required"  maxlength='200'> 



        <br><b>Respuesta: </b><br>

          <input type="text" class="form-control" id="lg_password" name="respuesta" value="<?php echo $value['respuesta']; ?>" required="required"  maxlength='200'> 

        <br><br><b>Segunda pregunta: </b><br>

          <input type="text" class="form-control" id="lg_password" name="pregunta2" value="<?php echo $value['pregunta2']; ?>" required="required"  maxlength='200'>

        <br><b>Respuesta: </b><br>

          <input type="text" class="form-control" id="lg_password" name="respuesta2" value="<?php echo $value['respuesta2']; ?>" required="required"  maxlength='200'> 

</div>
    </center>


<br><br><br><br>
<center>
  <button type="submit" class="btn btn-primary"><b>Cambiar Preguntas y Respuetas</b></button>
</center>

<center>

  <p class="text-success"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje3'); ?></b></p>

</center>




                      <?php endforeach ?>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
    
