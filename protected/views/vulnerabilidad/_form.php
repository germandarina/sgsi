<script>

    $(function () {
        if("<?= $model->id?>" != null){
            getDatosVulnerabilidad();
        }
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
                        $("#Vulnerabilidad_array_amenazas").find('option').remove();
                        $("#Vulnerabilidad_array_amenazas").select2('val', null);
                        $.each(amenazas, function (i, amenaza) {
                            $("#Vulnerabilidad_array_amenazas").append('<option value="' + amenaza.id + '">' + amenaza.nombre + '</option>');
                        });
                    }
                }
            });
        }
    }
    function getDatosVulnerabilidad() {
        getAmenazas();
        setTimeout(function () {
            getAmenazasPorVulnerabilidad();
        },200);
    }

    function getAmenazasPorVulnerabilidad() {
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('vulnerabilidad/getAmenazasPorVulnerabilidad')?>",
            data: {'id': "<?= $model->id ?>"},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var idsAmenazas = datos.idsAmenazas;
                $("#Vulnerabilidad_array_amenazas").select2('val', idsAmenazas);
                // if(amenazas.length >0){
                //     $("#Vulnerabilidad_array_amenazas").find('option').remove();
                //     $("#Vulnerabilidad_array_amenazas").select2('val', null);
                //     $.each(amenazas, function (i, amenaza) {
                //         $("#Vulnerabilidad_array_amenazas").append('<option value="' + amenaza.id + '">' + amenaza.nombre + '</option>');
                //     });
                // }
            }
        });


    }
</script>

<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'vulnerabilidad-form',
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
                    $model, 'array_amenazas',
                    [
                        'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                        'widgetOptions' => [
                            'asDropDownList' => true,
                            'data' => CHtml::listData(Amenaza::model()->findAll(), 'id', 'nombre'),
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