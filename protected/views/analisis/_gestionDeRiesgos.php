<table class="table">
    <thead>
        <tr>
            <th>Activo</th>
            <th>Riesgo Aceptable</th>
            <th>Nivel de Riesgo</th>
            <th>Valor del Activo</th>
            <th>Valor Confidencialidad</th>
            <th>Valor Integridad</th>
            <th>Valor Disponibilidad</th>
            <th>valor Trazabilidad</th>
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
                 <td><?= $detalle->grupoActivo->activo->nombre;?></td>
                 <td><?= $detalle->analisisRiesgo->riesgo_aceptable?></td>
                 <td><?= $concepto?></td>
                 <td><?= $detalle->valor_activo != 0 ? $detalle->valor_activo : "" ?></td>
                 <td><?= $detalle->valor_confidencialidad != 0 ? $detalle->valor_confidencialidad : ""  ?></td>
                 <td><?= $detalle->valor_integridad != 0 ? $detalle->valor_integridad : ""  ?></td>
                 <td><?= $detalle->valor_disponibilidad != 0 ? $detalle->valor_disponibilidad : ""  ?></td>
                 <td><?= $detalle->valor_trazabilidad != 0 ? $detalle->valor_trazabilidad : ""  ?></td>
             </tr>
         <?php }?>
    </tbody>
</table>