<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Nóminas</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
              <hr />
                <?php foreach ($datosper as $key => $value):?>

                              <b>Número de Cedula: </b> <?php echo $value[0]; ?><br><br>
                              <b>Nombres: </b><?php echo $value[1]; ?><br><br>
                              <b>Apellidos: </b><?php echo $value[2]; ?><br><br>                 
                              <b>Direccion: </b> <?php echo $value[3]; ?><br><br>
                              
                <?php endforeach ?>
                      <b><center>Seleccione la nómina a consultar</center></b><br><br>


<?php echo form_open('blog/pdfnomina',array('target'=>'_blank'));?>

<div class="col-xs-3">
   <select name="meses" class="form-control" required="required">
        <option value="" selected disabled>Mes:</option>
   <?php foreach ($meses as $key => $value):?>
        <option value=<?php echo $value[1];?>> <?php echo $value[0].' - '.$value[2]; ?></option>
  <?php endforeach ?> 
                      </select>
                    
</div>



<br><br><br><br>
<center>
  <button type="submit" class="btn btn-primary"><b>Crear Comprobante de Nómina</b></button>
</center>

<center>
  <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
</center>

 </form>               

    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->