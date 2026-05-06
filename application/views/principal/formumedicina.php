<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-28807146-1', 'auto');
  ga('send', 'pageview');
</script>

 <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2><center>Censo Medicinas</center></h2>   
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
<!--                  <center> <h3><?php echo $sesion." ".$apellido; ?></h3></center><br><br> 
<h4>Nota: Solo est&aacute;n disponible los medicamentos en el listado siguiente</h4>-->

<?php echo form_open('blog/censo_medicina');?>

<div class="col-xs-6">
<span><b>Seleciona un familiar:</b></span>
   <select name="familiar" class="form-control" required="required">
        <option value="" selected disabled>FAMILIAR:</option>
        <option value=<?php echo $cedula;?>><?php echo $apellido." ".$sesion; ?></option>
    <?php foreach ($familiares as $key => $value):?>
        <option value=<?php echo $value[2];?>> <?php echo $value[3]; ?></option>
    <?php endforeach ?> 
    </select>
                    
</div><br><br><br><br>
<div class="col-xs-6">

<span><b>Seleciona la Medicina que requiere el Familiar:</b></span>
</div><br>
<div class="col-xs-6">
          <select name="medicina" class="form-control" required="required">
                        <option value="" selected disabled>MEDICINA:</option>
                        <?php foreach ($medicinas as $key => $value):
                          
                          if ($value[2]==1) { ?> 
                            <option value=<?php echo $value[0];?>> <?php echo $value[1]; ?></option>
                          <?php }
                        ?>
                          
                        <?php endforeach ?> 
                      </select>
</div>
<br><br><br><br><center><button type="submit" class="btn btn-primary"><b>Agregar al Censo</b></button></center>
</form>
<center>

  <p class="text-success"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje'); ?></b></p>
    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje2'); ?></b></p>

</center>



  <center><h2>Listado de Medicinas solicitadas por familiar</h2><br></center>         
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Medicina</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($censo as $key => $value): ?>
      <tr>
 
        <td> <?php echo nombrefamiliar($value[1]);  ?> </td>

        <td> <?php echo $value[3] ?> </td>
        <td> <a onclick="if(confirma() == false) return false" href="<?=base_url()?>blog/eliminar_censo_medicina/<?=$value[1]?>/<?=$value[2]?>" class='btn btn-danger '>Quitar</a> </td>

      </tr>
<?php endforeach ?>

    </tbody>
  </table>

  <center>
    <p class="text-danger"><b><?php echo validation_errors(); echo $this->session->flashdata('mensaje3'); ?></b></p>
  </center>
    </div>

             <!-- /. PAGE INNER  -->
    

            </div>
         <!-- /. PAGE WRAPPER  -->
    
<script>
  function Delete(Codigo) {
    if (confirm('Estas seguro de Eliminar este registro?')){
        document.location='Cfacilitadores/borrar/'+Codigo;
    }
  }
</script>

<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
}
 else { 
 return false
 }
}
</script>

