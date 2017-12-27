<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'area-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>50)); ?>
            <?php echo $form->textFieldGroup($model,'descripcion',array('class'=>'col-sm-5','maxlength'=>200)); ?>
            <?php echo $form->textFieldGroup($model,'creaUserStamp',array('class'=>'col-sm-5','maxlength'=>50)); ?>
            <?php echo $form->textFieldGroup($model,'creaTimeStamp',array('class'=>'col-sm-5')); ?>
            <?php echo $form->textFieldGroup($model,'modUserStamp',array('class'=>'col-sm-5','maxlength'=>50)); ?>
            <?php echo $form->textFieldGroup($model,'modTimeStamp',array('class'=>'col-sm-5')); ?>
    
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'size'=>'small'
		)); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'label'=> 'Cancelar',
			'size' => 'small',
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>