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
        </tr>
    </thead>
    <tbody>
         <?php foreach ($detalles as $detalle){
              $nivel_riesgo = NivelDeRiesgos::model()->findByPk($detalle->nivel_riesgo_id);
              if(is_null($nivel_riesgo)){
                  $concepto = "";
              }else{
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
             </tr>
         <?php }?>
    </tbody>
</table>