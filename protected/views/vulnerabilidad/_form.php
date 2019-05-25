<script>

    $(function () {
       getAmenazas();
    });
    function getAmenazas() {
        var tipo_activo_id = $("#Vulnerabilidad_tipo_activo_id").val();
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
                        $("#Vulnerabilidad_amenaza_id").find('option').remove();
                        $("#Vulnerabilidad_amenaza_id").select2('val', null);
                        $.each(amenazas, function (i, amenaza) {
                            $("#Vulnerabilidad_amenaza_id").append('<option value="' + amenaza.id + '">' + amenaza.nombre + '</option>');
                        });
                    }
                }
            });
        }
    }
</script>

<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'vulnerabilidad-form',
	'enableAjaxValidation'=>false,
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
                            'data' => CHtml::listData(Amenaza::model()->findAll(), 'id', 'nombre'),
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
                    <?php echo $form->labelEx($model,'descripcion',array('class'=>'col-sm-3')); ?>
                    <?php echo $form->textArea($model,'descripcion',array('class'=>'col-sm-9','rows'=>6, 'cols'=>75)); ?>
            </div>
        </div>

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