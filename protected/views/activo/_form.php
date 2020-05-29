<script>
    function getPersonal() {
        var areas = $("#Activo_areas").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('area/getPersonal')?>",
            data: {'areas': areas},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var personal = datos.personal;
                $("#Activo_personal_id").find('option').remove();
                $("#Activo_personal_id").select2('val', null);
                if(personal.length >0){
                    $.each(personal, function (i, persona) {
                        $("#Activo_personal_id").append('<option value="' + persona.id + '">' + persona.apellido + ' ' + persona.nombre + '</option>');
                    });
                }
            }
        });
    }
</script>
<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'id'=>'activo-form',
	'type' => 'horizontal',
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
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
//                        'htmlOptions' => ['onChange'=>'getProcesos()'],
                        ],
                    ]
                );
                ?>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-sm-6">
                <?php echo $form->select2Group(
                    $model, 'areas',
                    [
                        'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                        'widgetOptions' => [
                            'asDropDownList' => true,
                            'data' => CHtml::listData(Area::model()->getAreasDisponiblesPorProyecto(), 'id', 'nombre'),
                            'options' => [
                                'minimumResultsForSearch' => 10,
                                'placeholder' => '--Seleccione--'
                            ],
                            'htmlOptions' => ['multiple'=>'multiple','onChange'=>'getPersonal()'],
                        ],
                    ]
                );
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->select2Group(
                    $model, 'personal_id',
                    [
                        'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                        'widgetOptions' => [
                            'asDropDownList' => true,
                            'data' => CHtml::listData(Personal::model()->getPersonalDisponiblePorProyecto(), 'id', 'nombre'),
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
                <?php echo $form->numberFieldGroup($model,'cantidad',array('class'=>'col-sm-5','maxlength'=>50)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldGroup($model,'ubicacion',array('class'=>'col-sm-5','maxlength'=>100)); ?>
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