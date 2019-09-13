<script>
    $(function () {
        var id = "<?= $model->id ?>";
        if(id != ""){
            getAmenazas();
        }
    });
    function getAmenazas() {
        var tipo_activo_id;
        if("<?= $model->tipo_activo_id ?>" != ""){
            tipo_activo_id = "<?= $model->tipo_activo_id ?>";
        }else{
            tipo_activo_id = $("#Control_tipo_activo_id").val();
        }

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
                        $("#Control_vulnerabilidad_id").find('option').remove();
                        $("#Control_vulnerabilidad_id").select2('val', null);
                        var id = "<?= $model->id ?>";
                        if(id != "") {
                            setTimeout(function () {
                                getVulnerabilidades();
                            }, 200);
                        }
                    }


                }
            });
        }
    }
    
    function getVulnerabilidades() {
        var amenaza_id;
        if("<?= $model->amenaza_id ?>" != ""){
            amenaza_id = "<?= $model->amenaza_id ?>";
            $("#Control_amenaza_id").select2('val', amenaza_id);
        }else{
            amenaza_id = $("#Control_amenaza_id").val();
        }
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
                        if("<?= $model->vulnerabilidad_id ?>" != ""){
                            $("#Control_vulnerabilidad_id").select2('val', <?= $model->vulnerabilidad_id ?>);
                        }
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
                        'data' => [],
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