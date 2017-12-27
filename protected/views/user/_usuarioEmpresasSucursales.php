 <br /><br />
 <fieldset><legend>Empresas y Sucursales</legend>
<?php 
  $empresas =  Empresa::model()->findAll();
  $usuarioSucursales = $model->sucursales;
  foreach ($empresas as $key => $empresa) {
        $sucursales = Sucursal::model()->findAll('empresaId=:empresaId',array(":empresaId"=>$empresa->id));
        if(count($sucursales)>0){
              echo "<b>EMPRESA: ".strtoupper($empresa->descripcion)."</b><br />";
              echo '<div class="table-responsive">';
              echo '<table class="table table-bordered">';
              echo '<tr><td style="width: 5%; background-color: #3c8dbc;color: #ffffff;font-weight: bold;">Activas</td>
                        <td style="width: 15%; background-color: #3c8dbc;color: #ffffff;font-weight: bold;">Sucursal</td></tr>';
              foreach ($sucursales as $key => $sucursal) {
                  $checkeado = false;
                  foreach ($usuarioSucursales as $key => $relacion) {
                     if($relacion->id == $sucursal->id) $checkeado = true;                
                  }
              ?>
              <tr>
                  <td>
                     <?php echo CHtml::checkbox('sucursal[]',$checkeado,array('id'=>'checkbox_id','value'=>$sucursal->id)); ?>
                  </td>
                  <td>
                      <?= $sucursal->nombre ?>
                  </td>
              </tr>
<?php        }
             echo "</table></div>"; 
     }   
 }
?>
