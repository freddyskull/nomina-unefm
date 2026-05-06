
 <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Cambiar correo</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
                <?php foreach ($empleado as $key => $value): ?>


                              <center><b>Correo actual: </b> <?php echo $value[5]; ?><br><br></center>


<?php echo form_open('blog/editar_correo2');?>
<b><br><center>Introduzca su nuevo correo:</center></b><br>

<div class="col-xs-4">
</div>

<div class="col-xs-4">
  <input type="email" class="form-control" id="lg_password" name="email" placeholder="Nuevo correo..." required="required"  maxlength='200'> 
</div>

<div class="col-xs-4">
</div>
<br><br><br><br>
<center>
  <button type="submit" class="btn btn-primary"><b>Cambiar correo</b></button>
</center>

<center>

  <p class="text-success"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>

</center>




                      <?php endforeach ?>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
    
