<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Cambiar Contraseña</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
              <hr />
               
                      <b><center>Introduzca su clave actual:</center></b><br>


<?php echo form_open('blog/editar_clave2');?>

<!-- <div class="col-xs-3">

                    
</div> -->
<div class="col-xs-4">
</div>

<div class="col-xs-4">
  <input type="password" class="form-control" id="lg_password" name="contraact" placeholder="Clave actual..." required="required"  maxlength='20'> 
</div>

<div class="col-xs-4">
</div>

<br><br><br><b><center>Introduzca su nueva clave:</center></b><br>

<div class="col-xs-4">
  <input type="password" class="form-control" id="lg_password" name="contra1" placeholder="Nueva clave..." required="required" maxlength='20'>
</div>

<div class="col-xs-4">
</div>

<div class="col-xs-4">
  <input type="password" class="form-control" id="lg_password" name="contra2" placeholder="Repetir clave..." required="required" maxlength='20'>
</div>

<br><br><br><br>
<center>
  <button type="submit" class="btn btn-primary"><b>Cambiar contraseña</b></button>
</center>

<center>
  <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
  <p class="text-success"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje2'); ?></b></p>

</center>

 </form>               

    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->