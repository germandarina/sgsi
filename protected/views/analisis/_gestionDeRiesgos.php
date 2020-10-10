<table class="table" border="1">
    <thead>
        <tr style="background-color: #bebebe;">
            <th  style="text-align: center;">Activo</th>
            <th  style="text-align: center;">Riesgo Aceptable</th>
            <th  style="text-align: center;">Nivel de Riesgo</th>
            <th  style="text-align: center;">Valor del Activo</th>
            <th  style="text-align: center;">Valor Confidencialidad</th>
            <th  style="text-align: center;">Valor Integridad</th>
            <th  style="text-align: center;">Valor Disponibilidad</th>
            <th  style="text-align: center;">Valor Trazabilidad</th>
            <th>Actuación</th>
            <th>Acción</th>
            <th>Transferir a</th>
            <th>Controles</th>
        </tr>
    </thead>
    <tbody>
         <?php foreach ($detalles as $detalle){
              $nivel_riesgo = NivelDeRiesgos::model()->findByPk($detalle->nivel_riesgo_id);
              $actuacion    = ActuacionRiesgo::model()->findByAttributes(['analisis_riesgo_detalle_id'=>$detalle->id]);
              $concepto = "";
              if($nivel_riesgo){
                  $concepto = NivelDeRiesgos::$arrayConceptos[$nivel_riesgo->concepto];
              }
             ?>
             <tr>
                 <td style="text-align: center;"><?= $detalle->grupoActivo->activo->nombre;?></td>
                 <td style="text-align: center;"><?= $detalle->analisisRiesgo->riesgo_aceptable?></td>
                 <td style="text-align: center;"><?= $concepto?></td>
                 <td style="text-align: center;"><?= $detalle->valor_activo != 0 ? $detalle->valor_activo : "" ?></td>
                 <td style="text-align: center;"><?= $detalle->valor_confidencialidad != 0 ? $detalle->valor_confidencialidad : ""  ?></td>
                 <td style="text-align: center;"><?= $detalle->valor_integridad != 0 ? $detalle->valor_integridad : ""  ?></td>
                 <td style="text-align: center;"><?= $detalle->valor_disponibilidad != 0 ? $detalle->valor_disponibilidad : ""  ?></td>
                 <td style="text-align: center;"><?= $detalle->valor_trazabilidad != 0 ? $detalle->valor_trazabilidad : ""  ?></td>
                 <?php if($actuacion) { ?>

                    <td style="text-align: left;">Fecha: <?= Utilities::ViewDateFormat($actuacion->fecha) ?>&nbsp;Descripción: <?= $actuacion->descripcion ?></td>

                    <td style="text-align: center;"><?= ActuacionRiesgo::$acciones[$actuacion->accion] ?></td>

                     <?php if($actuacion->accion == ActuacionRiesgo::ACCION_REDUCION) { ?>
                         <td style="text-align: center;">-</td>
                         <?php $controles =  Control::model()->getControlesEnRiesgoParaReporte($detalle->id); ?>
                         <?php if(!empty($controles)) { $controles_string = implode('/',$controles);  ?>
                            <td style="text-align: left;"><?= $controles_string ?></td>
                         <?php } else{ ?>
                             <td style="text-align: left;">ESTE ACTIVO NO POSEE CONTROLES EN RIESGO</td>
                         <?php }?>
                     <?php }else if($actuacion->accion == ActuacionRiesgo::ACCION_TRANSFERIR) { ?>
                         <td style="text-align: center;"><?= ActuacionRiesgo::$accionesTransferir[$actuacion->accion_transferir] ?></td>
                         <td style="text-align: center;">-</td>
                     <?php } else {?>
                         <td style="text-align: center;">-</td>
                         <td style="text-align: center;">-</td>
                 <?php } }
                 else
                     { ?>
                         <th>Sin Actuación Definida</th>
                         <th>Sin Actuación Definida</th>
                         <th>Sin Actuación Definida</th>
                         <th style="text-align: center;">-</th>
                 <?php }?>
             </tr>
         <?php }?>
    </tbody>
</table>