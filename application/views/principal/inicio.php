<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
             <center><h2>Inicio</h2></center> 

                <h5></h5>
               
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

         <?php endforeach ?>


        <table width="70%" border="1" align="center" bordercolor="#000033">
            <tr>
                <th width="100%" colspan="7" bgcolor="#B7C6FF"><center><b>CARGA FAMILIAR</b></center></th>
            </tr>
            <tr>
                <th width="10%"  bgcolor="#B7C6FF"><center><b>CEDULA</b></center></th>
                <th width="15%"  bgcolor="#B7C6FF"><center><b>NOMBRE</b></center></th>
                <th width="15%"  bgcolor="#B7C6FF"><center><b>APELLIDO</b></center></th>
                <th width="10%"  bgcolor="#B7C6FF"><center><b>FECHA NACIMIENTO</b></center></th>
                <th width="10%"  bgcolor="#B7C6FF"><center><b>SEXO</b></center></th>
                <th width="10%"  bgcolor="#B7C6FF"><center><b>PARENTESCO</b></center></th>
                <th width="10%"  bgcolor="#B7C6FF"><center><b>CODICION ESPECIAL</b></center></th>
            </tr>

            
             <?php 
             if ($cargaf!=null) {
                      

             foreach ($cargaf as $key => $value):?>
                <tr>
                    <td><?php echo $value[1]; ?></td>
                    <td><?php echo $value[2]; ?></td>
                    <td><?php echo $value[3]; ?></td>
                    <td><center><?php echo $value[5]; ?></center></td>
                    <td><center><?php echo $value[4]; ?></center></td>
                    <td><center><?php echo $value[6]; ?></center></td>
                    <td><center><?php echo $value[7]; ?></center></td>
                </tr>
            
            <?php endforeach;    
            }
            ?>

            

        </table>


    </div>
             <!-- /. PAGE INNER  -->
</div>
         <!-- /. PAGE WRAPPER  -->
</div>
           
</div>
