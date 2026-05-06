
 <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Datos de usuario</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
                <?php foreach ($empleado as $key => $value): ?>

                              <b>Nombres: </b><?php echo $value[1]; ?><br><br>
                              <b>Apellidos: </b><?php echo $value[2]; ?><br><br>
                              <b>Número de Cedula: </b> <?php echo $value[0]; ?><br><br>
                              <b>Direccion: </b> <?php echo $value[3]; ?><br><br>
                              <b>Telefono: </b> <?php echo $value[4]; ?><br><br>
                              <b>Email: </b> <?php echo $value[5]; ?><br><br>
                              <b>Fecha de Nacimiento: </b> <?php echo $value[6]; ?><br><br>
                              <b>Lugar de Nacimiento: </b> <?php echo $value[7]; ?><br><br>
                              <b>País de Nacimiento: </b> <?php echo $value[8]; ?><br><br>
                              <b>RIF: </b> <?php echo $value[9]; ?><br><br>


                      <?php endforeach ?>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
    
