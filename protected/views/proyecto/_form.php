<script>
    $(function () {
        getAreasPorOrganizacion();
    });

    function getAreasPorOrganizacion() {
        var organizacion_id = $("#Proyecto_organizacion_id").val();
        if(organizacion_id != "" && organizacion_id != null && organizacion_id != undefined){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('organizacion/getAreas')?>",
                data: {
                        'organizacion_id': organizacion_id,
                        'proyecto_id' : '<?= $model->id ?>',
                        },
                dataType: 'Text',
                success: function (data) {
                    var datos = jQuery.parseJSON(data);
                    var areas = datos.areas;
                    var areasIds = datos.areasIds;
                    $("#Proyecto_areas").find('option').remove();
                    $("#Proyecto_areas").select2('val', null);
                    if(areas.length >0){
                        $.each(areas, function (i, organizacion) {
                            $("#Proyecto_areas").append('<option value="' + organizacion.id + '">' + organizacion.nombre + '</option>');
                        });
                        if("<?= $model->organizacion_id ?>" != ""){
                            $("#Proyecto_areas").select2('val', <?= $model->organizacion_id ?>);
                        }
                    }

                    $("#Proyecto_areas").select2("val",areasIds);
                }
            });
        }
    }
</script>
<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'id'=>'proyecto-form',
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
                $model, 'organizacion_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Organizacion::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onchange'=>'getAreasPorOrganizacion()'],
                    ],
                ]
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'areas',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => $model->areas,//CHtml::listData(Area::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['multiple'=>'multiple'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'usuarios',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(User::model()->getUsuariosAuditoresYGerencial(), 'id', 'username'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['multiple'=>'multiple'],
                    ],
                ]
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>50)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->datePickerGroup($model, 'fecha', [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        //'startDate' => ($model->fecha),
                        //'endDate' => ($model->fecha),
                    ],
                    'htmlOptions' => ['readonly' => 'readonly']
                ],
                'wrapperHtmlOptions' => ['class' => 'col-sm-9 input-group-sm'],
                'prepend' => '<i class="fa fa-calendar"></i>'
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->labelEx($model,'descripcion',array('class'=>'col-sm-3')); ?>
            <?php echo $form->textArea($model,'descripcion',array('class'=>'col-sm-9','rows'=>6, 'cols'=>75)); ?>
        </div>
    </div>
    <br>

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