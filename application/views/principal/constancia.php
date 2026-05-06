<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Constancias de Trabajo</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
              <hr/>

                <?php foreach ($datosper as $key => $value):?>

                              <b>Número de Cedula: </b> <?php echo $value[0]; ?><br><br>
                              <b>Nombres: </b><?php echo $value[1]; ?><br><br>
                              <b>Apellidos: </b><?php echo $value[2]; ?><br><br>                 
                              <b>Direccion: </b> <?php echo $value[3]; ?><br><br>
                              <b>Condicion del empleado: </b> <?php echo $value[4]; ?>-<?php echo $value[5]; ?><br><br>

                      <b><center>Seleccione los datos para su constancia</center></b><br><br>

   
                      <?php echo form_open('blog/pdf',array('target'=>'_blank'));?>
                        <div class="col-xs-3">
                           <select name="sueldo" class="form-control" required="required">
                            <option value="" selected disabled>Tipo de sueldo:</option>
                          	<option value="01">Sueldo Integral</option>
                          	<option value="02">Sueldo Anual</option>
                          	<option value="03">Sueldo Basico</option>
                          	<option value="04">Sin Sueldo</option>
                          </select>
                        </div>
                        
                        <div class="col-xs-6"></div>
                        <div class="col-xs-3">
                            <select name="ces" class="form-control" required="required">
                              <option value="" selected disabled>Cesta Ticket:</option>
                            	<option value="01">Sin Cesta Ticket</option>
                            	<option value="02">Con Cesta Ticket</option>
                            </select>
                        </div>

                 <?php endforeach ?>

                  <br><br><br><br><center><button type="submit" class="btn btn-primary"><b>Crear Constancia</b></button></center>

                  <center>
                    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
                  </center>

                  </form>               

    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->