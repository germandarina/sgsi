<script>
    function levantarModalRiesgoAceptable() {
        $("#valor_riesgo_aceptable").val(1);
        $("#modalRiesgoAceptable").modal('show');
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
                <button type="button" onclick="js:guardarAsociacion()" class="btn btn-success" id="botonModal">
                    Guardar
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>
