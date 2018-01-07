<script>
//    function levantarModal() {
//        $("#ControlValor_fecha").val("");
//        $("#ControlValor_valor").val(0);
//        $("#ControlValor_valor").attr('min',0);
//        $("#modalFormDetalle").modal("show");
//    }
//    function mostrarValor(control_valor_id) {
//        $.ajax({
//            type: 'POST',
//            url: "<?php //echo CController::createUrl('control/getControlValor')?>//",
//            data: {'control_valor_id': control_valor_id},
//            dataType: 'Text',
//            success: function (data) {
//                var datos = jQuery.parseJSON(data);
//                var control_valor = datos.controlValor;
//                $("#ControlValor_valor").attr('min',0);
//                $("#ControlValor_fecha").val(control_valor.fecha);
//                $("#ControlValor_valor").val(control_valor.valor);
//                $("#modalFormDetalle").modal("show");
//            }
//        });
//    }
//
//    function eliminarDetalle(control_valor_id) {
//
//        Lobibox.confirm({
//            title: 'Confirmar',
//            msg : 'Esta seguro de eliminar el valor?',
//            callback: function (lobibox,type) {
//                if(type == 'yes'){
//                    $.ajax({
//                        type: 'POST',
//                        url: "<?php //echo CController::createUrl('control/eliminarControlValor')?>//",
//                        data: {'control_valor_id': control_valor_id},
//                        dataType: 'Text',
//                        success: function (data) {
//                            var datos = jQuery.parseJSON(data);
//                            if(datos.error == 1){
//                                 Lobibox.notify('error',{msg: "Error al eliminar, intentelo de nuevo."});
//                            }else{
//                                Lobibox.notify('success',{msg: "Se elimino correctamente"});
//                            }
//                            $.fn.yiiGridView.update('control-valor-grid');
//                        }
//                    });
//                }else{
//                    return false;
//                }
//            }
//        });
//
//    }
//    function guardarValores() {
//        var fecha = $("#ControlValor_fecha").val();
//        var valor = $("#ControlValor_valor").val();
//        if(fecha == "" || valor == ""){
//            return Lobibox.notify('error',{msg: "Debe completar el formulario"})
//        }
//        var control_id = $("#control_id").val();
//        var control_valor_id = $("#control_valor_id").val();
//        $.ajax({
//            type: 'POST',
//            url: "<?php //echo CController::createUrl('control/guardarControlValor')?>//",
//            data: { 'fecha': fecha,
//                    'valor': valor,
//                    'control_id':control_id,
//                    'control_valor_id':control_valor_id
//                },
//            dataType: 'Text',
//            success: function (data) {
//                var datos = jQuery.parseJSON(data);
//                if(datos.error == 1){
//                    Lobibox.notify('error',{msg: "Error al guardar, intentelo de nuevo."});
//                }else{
//                    Lobibox.notify('success',{msg: "Se guardo correctamente"});
//                    $("#modalFormDetalle").modal("hide");
//                }
//                $.fn.yiiGridView.update('control-valor-grid');
//
//            }
//        });
//    }
</script>
<style>
    a.linkCredito {
        cursor: pointer;
    }
</style>
<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'control-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
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