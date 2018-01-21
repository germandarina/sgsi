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
    'dataProvider' => $grupo_activo->search(),
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
