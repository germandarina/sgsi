<script>
    $(function () {
        var area_id = "<?= $model->area_id ?>";
        if(area_id != "" && area_id != null && area_id != undefined){
            getProcesos();
            setTimeout(function(){
                $("#Personal_proceso_id").select2('val', area_id);
            }, 500);
        }
    });
    function getProcesos() {
        var area_id = $("#Personal_area_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('area/getProcesos')?>",
            data: {'area_id': area_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var procesos = datos.procesos;

                $("#Personal_proceso_id").find('option').remove();
                $("#Personal_proceso_id").select2('val', null);
                if(procesos.length >0){
                    $.each(procesos, function (i, proceso) {
                        $("#Personal_proceso_id").append('<option value="' + proceso.id + '">' + proceso.nombre + '</option>');
                    });
                }
            }
        });
    }
</script>

<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'personal-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'area_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Area::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onChange'=>'getProcesos()'],
                    ],
                ]
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'proceso_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Proceso::model()->findAll(), 'id', 'nombre'),
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
            <?php echo $form->textFieldGroup($model,'apellido',array('class'=>'col-sm-5','maxlength'=>50)); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>50)); ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'dni',array('class'=>'col-sm-5','maxlength'=>50)); ?>

        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'telefono',array('class'=>'col-sm-5','maxlength'=>50)); ?>

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