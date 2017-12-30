<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'tipo-activo-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
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
                <?php echo $form->textFieldGroup($model,'descripcion',array('class'=>'col-sm-5','maxlength'=>50)); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?php echo $form->label($model,'confidencialidad',array('class'=>'col-sm-9')); ?>
                <?php echo $form->checkBox($model,'confidencialidad',array('class'=>'col-sm-3')); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->label($model,'integridad',array('class'=>'col-sm-9')); ?>
                <?php echo $form->checkBox($model,'integridad',array('class'=>'col-sm-3')); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->label($model,'disponibilidad',array('class'=>'col-sm-9')); ?>
                <?php echo $form->checkBox($model,'disponibilidad',array('class'=>'col-sm-3')); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->label($model,'trazabilidad',array('class'=>'col-sm-9')); ?>
                <?php echo $form->checkBox($model,'trazabilidad',array('class'=>'col-sm-3')); ?>
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