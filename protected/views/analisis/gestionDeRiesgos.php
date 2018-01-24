<script>
    function levantarModalRiesgoAceptable() {
        $("#valor_riesgo_aceptable").val(1);
        $("#modalRiesgoAceptable").modal('show');
    }
    
    function guardarRiesgoAceptable() {
        var analisis_id = $("#analisis_id").val();
        var riesgo_aceptable = $("#valor_riesgo_aceptable").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/guardarRiesgoAceptable')?>",
            data: {
                'riesgo_aceptable': riesgo_aceptable,
                'analisis_id': analisis_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 0){
                    $("#modalRiesgoAceptable").modal('hide');
                    Lobibox.notify('success',{msg: datos.msj});
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
                $.fn.yiiGridView.update('activos-grid');
            }
        });
    }
    function evaluarActivos() {
        $("#modalProcesando").modal('show');
        var analisis_id = $("#analisis_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/evaluarActivos')?>",
            data: {
                'analisis_id': analisis_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 0){
                    Lobibox.notify('success',{msg: datos.msj});
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
                $("#modalProcesando").modal('hide');
                $.fn.yiiGridView.update('activos-grid');
            }
        });
    }
</script>

<div class="box-header">
    <?php $this->widget('booster.widgets.TbButton', array(
        'label'=> 'Riesgo Aceptable ( + )',
        'context'=>'success',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:levantarModalRiesgoAceptable()')
    ));
    ?>

    <?php $this->widget('booster.widgets.TbButton', array(
        'label'=> 'Evaluar Activos',
        'context'=>'primary',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:evaluarActivos()')
    ));
    ?>
</div>

<?php
    $this->widget('booster.widgets.TbExtendedGridView',array(
    'id'=>'activos-grid',
    'fixedHeader' => false,
    'headerOffset' => 10,
    // 40px is the height of the main navigation at bootstrap
    'type' => 'striped hover condensed',
    'dataProvider' => $grupo_activo->searchGestionRiesgos(),
    'responsiveTable' => true,
    'template' => "{summary}\n{items}\n{pager}",
    'selectableRows' => 1,
    //'filter' => $grupo_activo,
    'columns'=>array(
        array(
            'name'=>'activo_id',
            'header'=>'Activo',
            'value'=>'$data->activo->nombre',
        ),
        array(
            'name'=>'analisis_riesgo_id',
            'header'=>'Valor Riesgo Aceptable',
            'value'=>function($data){
                $analisis_riesgo = AnalisisRiesgo::model()->findByPk($data->analisis_riesgo_id);
                return $analisis_riesgo->riesgo_aceptable;
            },
        ),
        array(
            'type'=>'raw',
            'name'=>'nivel_riesgo_id',
            'header'=>'Nivel de Riesgo',
            'value'=>function($data){
                if(!is_null($data->nivel_riesgo_id)){
                        switch ($data->nivel_riesgo_id){
                            case NivelDeRiesgos::CONCEPTO_ACEPTABLE:
                                return "<span class='label label-success'>".NivelDeRiesgos::$arrayConceptos[$data->nivel_riesgo_id]."</span>";
                                break;
                            case NivelDeRiesgos::CONCEPTO_ACEPTABLE_CON_PRECAUCION:
                                return "<span class='label label-warning' style='font-size: 12px;'>".NivelDeRiesgos::$arrayConceptos[$data->nivel_riesgo_id]."</span>";
                                break;
                            case NivelDeRiesgos::CONCEPTO_NO_ACEPTABLE:
                                return "<span class='label label-danger' style='font-size: 12px;'>".NivelDeRiesgos::$arrayConceptos[$data->nivel_riesgo_id]."</span>";
                                break;
                        }
                }else{
                    return "";
                }
            },
        ),
        array(
            'type'=>'raw',
            'name'=>'valor_activo',
            'header'=>'Valor Activo',
            'value'=>function($data){
                $analisis_riesgo = AnalisisRiesgo::model()->findByPk($data->analisis_riesgo_id);
                if($analisis_riesgo->riesgo_aceptable < $data->valor_activo){
                    return "<span class='label label-success' style='font-size: 12px;'><i class='fa fa-long-arrow-up' aria-hidden='true'></i></span>&nbsp;".$data->valor_activo;
                }
                if($analisis_riesgo->riesgo_aceptable > $data->valor_activo){
                    return "<span class='label label-success' style='font-size: 12px;'><i class='fa fa-long-arrow-down' aria-hidden='true'></i></span>&nbsp;".$data->valor_activo;

                }
                if($analisis_riesgo->riesgo_aceptable == $data->valor_activo){
                    return "<span class='label label-success' style='font-size: 12px;'><i class='fa fa-exchange' aria-hidden='true'></i></span>&nbsp;".$data->valor_activo;

                }
            }
        ),
        array(
            'name'=>'valor_confidencialidad',
            'header'=>'Valor Confidencialidad',
            'value'=>'$data->valor_confidencialidad',
        ),
        array(
            'name'=>'valor_integridad',
            'header'=>'Valor Integridad',
            'value'=>'$data->valor_integridad',
        ),
        array(
            'name'=>'activo_disponibilidad',
            'header'=>'Valor Disponibilidad',
            'value'=>'$data->valor_disponibilidad',
        ),
        array(
            'name'=>'valor_trazabilidad',
            'header'=>'Valor Trazabilidad',
            'value'=>'$data->valor_trazabilidad',
        ),
    ),
)); ?>


<div class="modal fade" id="modalRiesgoAceptable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Riesgo Aceptable</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <div class="box-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label required" for="Organizacion_nombre">Valor Riesgo Aceptable <span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" placeholder="Valor" name="valor_riesgo_aceptable" id="valor_riesgo_aceptable" type="number" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarRiesgoAceptable()" class="btn btn-success" id="botonModal">
                    Guardar
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProcesando" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="cabeceraModal">Procesando....</h3>
            </div>
        </div>
    </div>
</div>


