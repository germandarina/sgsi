<script>
    $(function () {
        getAmenazas();
    });
    function getAmenazas() {
        var tipo_activo_id = $("#Control_tipo_activo_id").val();
        if(tipo_activo_id != "" && tipo_activo_id != 0  && tipo_activo_id != null && tipo_activo_id != undefined){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('vulnerabilidad/getAmenazas')?>",
                data: {'tipo_activo_id': tipo_activo_id},
                dataType: 'Text',
                success: function (data) {
                    var datos = jQuery.parseJSON(data);
                    var amenazas = datos.amenazas;

                    if(amenazas.length >0){
                        $("#Control_amenaza_id").find('option').remove();
                        $("#Control_amenaza_id").select2('val', null);
                        $.each(amenazas, function (i, amenaza) {
                            $("#Control_amenaza_id").append('<option value="' + amenaza.id + '">' + amenaza.nombre + '</option>');
                        });
                    }
                }
            });
        }
    }
    
    function getVulnerabilidades() {
        var amenaza_id = $("#Control_amenaza_id").val();
        if(amenaza_id != "" && amenaza_id != 0  && amenaza_id != null && amenaza_id != undefined){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('control/getVulnerabilidades')?>",
                data: {'amenaza_id': amenaza_id},
                dataType: 'Text',
                success: function (data) {
                    var datos = jQuery.parseJSON(data);
                    var vulnerabilidades = datos.vulnerabilidades;

                    if(vulnerabilidades.length >0){
                        $("#Control_vulnerabilidad_id").find('option').remove();
                        $("#Control_vulnerabilidad_id").select2('val', null);
                        $.each(vulnerabilidades, function (i, vulnerabilidad) {
                            $("#Control_vulnerabilidad_id").append('<option value="' + vulnerabilidad.id + '">' + vulnerabilidad.nombre + '</option>');
                        });
                    }
                }
            });
        }
    }
</script>

<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'control-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'tipo_activo_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(TipoActivo::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onChange'=>'getAmenazas()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'amenaza_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => [],
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onChange'=>'getVulnerabilidades()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>



    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'vulnerabilidad_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Vulnerabilidad::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
//                        'htmlOptions' => ['onChange'=>'getProcesos()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>50)); ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'numeracion',array('class'=>'col-sm-5','maxlength'=>50)); ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
                <?php echo $form->labelEx($model,'descripcion',array('class'=>'col-sm-3')); ?>
                <?php echo $form->textArea($model,'descripcion',array('class'=>'col-sm-9','rows'=>6, 'cols'=>75)); ?>
        </div>
    </div>

    <br>
<!--    --><?php //if(!$model->isNewRecord) { ?>
<!--    <div class="panel box box-solid box-primary">-->
<!--        <div class="box-header with-border">-->
<!--            <h4 class="box-title">-->
<!--                Valores Control-->
<!--            </h4>-->
<!--            <div class="box-tools pull-right">-->
<!--                <button type="button" class="btn btn-box-tool" data-widget="collapse">-->
<!--                    <i class="fa fa-minus"></i>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="box-body">-->
<!--            <div class="box-header with-border">-->
<!--                --><?php
//                    $this->widget('booster.widgets.TbButton', array(
//                        'label' => 'Agregar Valor ( + )',
//                        'context' => 'primary',
//                        'size' => 'small',
//                        'id' => "botonModal",
//                        'htmlOptions' => array('onclick' => 'js:levantarModal()', 'class' => "btn btn-success"),
//                    ));
//
//                    $this->widget('booster.widgets.TbExtendedGridView', array(
//                        'id' => 'control-valor-grid',
//                        'fixedHeader' => false,
//                        'headerOffset' => 10,
//                        // 40px is the height of the main navigation at bootstrap
//                        'type' => 'striped hover condensed',
//                        'dataProvider' => $controlValor->search(),
//                        'responsiveTable' => true,
//                        'template' => "{summary}\n{items}\n{pager}",
//                        'selectableRows' => 1,
//                        //'filter' => $model,
//                        'columns' => array(
//                            array(
//                                'name'=>'fecha',
//                                'header'=>'Fecha',
//                                'value'=>'Utilities::ViewDateFormat($data->fecha)',
//                            ),
//                            'valor',
//                            'creaUserStamp',
//                            'creaTimeStamp',
//                            [
//                                'header' => 'Acciones',
//                                'type' => 'raw',
//                                'value' => '"<a onclick=\"mostrarValor($data->id) \" title=\"Presione para ver\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-eye-open\"></i></a>&nbsp;&nbsp;<a onclick=\"eliminarDetalle($data->id) \" title=\"Presione para eliminar\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-trash\"></i></a>"',
//                            ]
//                        ),
//                    ));
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?php //} ?>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'size'=>'small'
		)); ?>

        <?php $this->widget('booster.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => 'Volver',
            'size' => 'small',
            'buttonType' => 'link',
            'url' => $this->createUrl("admin"),
        )); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>
<?php //if(!$model->isNewRecord) { ?>
<!--<div class="modal fade" id="modalFormDetalle" tabindex="-1" role="dialog" aria-hidden="true">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h4 class="modal-title" id="cabeceraModal">Nuevo Valor</h4>-->
<!--            </div>-->
<!--            <div class="modal-body" id="cuerpoDetalleCredito">-->
<!--                --><?php //echo $this->renderPartial('/controlValor/_form', array('model' => $model, 'controlValor' => $controlValor,)); ?>
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" onclick="js:guardarValores()" class="btn btn-success" id="botonModal">-->
<!--                    Agregar Valor-->
<!--                </button>-->
<!--                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php //}?>