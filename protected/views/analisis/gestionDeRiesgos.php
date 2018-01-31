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
    
    function getActuacion(event,analisis_riesgo_detalle_id) {
        event.preventDefault();
        $("#analisis_riesgo_detalle_id").val(analisis_riesgo_detalle_id);
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/getActuacion')?>",
            data: {
                'analisis_riesgo_detalle_id': analisis_riesgo_detalle_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                   $("#ActuacionRiesgo_fecha").val(datos.fecha);
                   $("#ActuacionRiesgo_descripcion").val(datos.descripcion);


                $("#modalActuacion").modal('show');
            }
        });
    }
    function crearActualizarActuacion() {
       var fecha = $("#ActuacionRiesgo_fecha").val();
       var descripcion = $("#ActuacionRiesgo_descripcion").val();
       var analisis_riesgo_detalle_id = $("#analisis_riesgo_detalle_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/crearActualizarActuacion')?>",
            data: {
                'analisis_riesgo_detalle_id': analisis_riesgo_detalle_id,
                'fecha':fecha,
                'descripcion':descripcion
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 0){
                    Lobibox.notify('success',{msg: datos.msj});
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
                $("#modalActuacion").modal('hide');
            }
        });

    }
    
    function exportarExcel() {
        $("#modalProcesando").modal('show');
        var analisis_id = $("#analisis_id").val();
        var href = "<?php echo CHtml::normalizeUrl(array('analisis/exportarGestionDeRiegosExcel'))?>";
        params = 'analisis_id='+analisis_id;
        url = href + '?' + params;
        window.open(url);
        $("#modalProcesando").modal('hide');
    }
    
    function exportarPDF() {
       // $("#modalProcesando").modal('show');
        var analisis_id = $("#analisis_id").val();
        var href = "<?php echo CHtml::normalizeUrl(array('analisis/exportarGestionDeRiegosPDF'))?>";
        params = 'analisis_id='+analisis_id;
        url = href + '?' + params;
        window.open(url);
      //  $("#modalProcesando").modal('hide');
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

    <?php $this->widget('booster.widgets.TbButton', array(
        'label'=> 'Exportar a Excel',
        'context'=>'default',
        'icon'=>'fa fa-file-excel-o',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:exportarExcel()','style'=>'float:right;')
    ));
    ?>

    <?php $this->widget('booster.widgets.TbButton', array(
        'label'=> 'Exportar a PDF',
        'context'=>'default',
        'icon'=>'fa fa-file-pdf-o',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:exportarPDF()','style'=>'float:right;')
    ));
    ?>
</div>

<?php
    $this->widget('booster.widgets.TbExtendedGridView',array(
    'id'=>'activos-grid',
    'fixedHeader' => false,
    'headerOffset' => 10,
   // 'rowCssClassExpression'=>'$data->getClaseNivelDeRiesgo()',
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
                    $label = $data->getClaseNivelDeRiesgo();
                    return "<span class='".$label."' style='font-size: 12px;' >".NivelDeRiesgos::$arrayConceptos[$data->nivel_riesgo_id]."</span>";
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
                if($data->valor_activo != 0 && !is_null($data->valor_activo)){
                    $labelFlecha = $data->getClaseFlechaRiesgoAceptable();
                    $label = $data->getClaseNivelDeRiesgo();
                    return "<i class='".$labelFlecha."' style='color:green' aria-hidden='true'></i>&nbsp;"."<span class='".$label."' style='font-size: 12px;' >".$data->valor_activo."</span>";
                }else{
                    return "";
                }

//                $analisis_riesgo = AnalisisRiesgo::model()->findByPk($data->analisis_riesgo_id);
//                if($analisis_riesgo->riesgo_aceptable < $data->valor_activo){
//                }
//                if($analisis_riesgo->riesgo_aceptable > $data->valor_activo){
//                    return "<i class='".$label."' style='color:green' aria-hidden='true'></i>&nbsp;".$data->valor_activo;
//                }
//                if($analisis_riesgo->riesgo_aceptable == $data->valor_activo){
//                    return "<i class='".$label."' style='color:green' aria-hidden='true'></i>&nbsp;".$data->valor_activo;
//                }
            }
        ),
        array(
            'type'=>'raw',
            'name'=>'valor_confidencialidad',
            'header'=>'Valor Confidencialidad',
            'value'=>function($data){
                if($data->valor_confidencialidad != 0 && !is_null($data->valor_confidencialidad)){
                    $labelFlecha = $data->getClaseFlechaRiesgoAceptable();
                    $label = $data->getClaseNivelDeValores($data->valor_confidencialidad);
                    return "<i class='".$labelFlecha."' style='color:green' aria-hidden='true'></i>&nbsp;"."<span class='".$label."' style='font-size: 12px;' >".$data->valor_confidencialidad."</span>";

                }else{
                    return "";
                }
            },
        ),
        array(
            'type'=>'raw',
            'name'=>'valor_integridad',
            'header'=>'Valor Integridad',
            'value'=>function($data){
                if($data->valor_integridad != 0 && !is_null($data->valor_integridad)){
                    $labelFlecha = $data->getClaseFlechaRiesgoAceptable();
                    $label = $data->getClaseNivelDeValores($data->valor_integridad);
                    return "<i class='".$labelFlecha."' style='color:green' aria-hidden='true'></i>&nbsp;"."<span class='".$label."' style='font-size: 12px;' >".$data->valor_integridad."</span>";

                }else{
                    return "";
                }
            },
        ),
        array(
            'type'=>'raw',
            'name'=>'activo_disponibilidad',
            'header'=>'Valor Disponibilidad',
            'value'=>function($data){
                if($data->valor_disponibilidad != 0 && !is_null($data->valor_disponibilidad)){
                    $labelFlecha = $data->getClaseFlechaRiesgoAceptable();
                    $label = $data->getClaseNivelDeValores($data->valor_disponibilidad);
                    return "<i class='".$labelFlecha."' style='color:green' aria-hidden='true'></i>&nbsp;"."<span class='".$label."' style='font-size: 12px;' >".$data->valor_disponibilidad."</span>";

                }else{
                    return "";
                }
            },
        ),
        array(
            'type'=>'raw',
            'name'=>'valor_trazabilidad',
            'header'=>'Valor Trazabilidad',
            'value'=>function($data){
                if($data->valor_trazabilidad != 0 && !is_null($data->valor_trazabilidad)){
                    $labelFlecha = $data->getClaseFlechaRiesgoAceptable();
                    $label = $data->getClaseNivelDeValores($data->valor_trazabilidad);
                    return "<i class='".$labelFlecha."' style='color:green' aria-hidden='true'></i>&nbsp;"."<span class='".$label."' style='font-size: 12px;' >".$data->valor_trazabilidad."</span>";

                }else{
                    return "";
                }
            },
        ),
        [
            'header' => 'Actuaciones',
            'type' => 'raw',
            'value' => '"<a onclick=\"getActuacion(event, $data->analisis_riesgo_detalle_id) \" title=\"Actuacion de Activo\" class=\"linkCredito\"><i class=\"fa fa-cogs \"></i></a>"',
        ],
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

<div class="modal fade" id="modalActuacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Actuacion</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <div class="box-body">
                    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                        'id'=>'area-form',
                        'enableAjaxValidation'=>false,
                        'type' => 'horizontal'
                    )); ?>

                    <input type="hidden" id="analisis_riesgo_detalle_id">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php echo $form->datepickerGroup($actuacion, 'fecha', [
                                    'widgetOptions' => [
                                        'options' => [
                                            'format' => 'dd/mm/yyyy',
                                            'autoclose' => true,
                                            'startDate' => ($actuacion->fecha),
                                            'endDate' => ($actuacion->fecha),
                                        ],
                                       // 'htmlOptions' => ['readonly' => 'readonly']
                                    ],
                                    'wrapperHtmlOptions' => ['class' => 'col-sm-9 input-group-sm'],
                                    'prepend' => '<i class="fa fa-calendar"></i>'
                                ]); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($actuacion,'descripcion',array('class'=>'col-sm-3')); ?>
                                <?php echo $form->textArea($actuacion,'descripcion',array('class'=>'col-sm-9','rows'=>6, 'cols'=>75)); ?>
                            </div>
                        </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:crearActualizarActuacion()" class="btn btn-success" id="botonModal">
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


