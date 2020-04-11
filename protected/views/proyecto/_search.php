<?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

		<?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>50)); ?>

		<?php echo $form->textFieldGroup($model,'descripcion',array('class'=>'col-sm-5','maxlength'=>200)); ?>

		<?php echo $form->datepickerGroup($model,'fecha',array('options'=>array(),'htmlOptions'=>array('class'=>'col-sm-5')),array('prepend'=>'<i class="fa fa-calendar"></i>')); ?>

		<?php echo $form->textFieldGroup($model,'creaUserStamp',array('class'=>'col-sm-5','maxlength'=>50)); ?>

		<?php echo $form->textFieldGroup($model,'creaTimeStamp',array('class'=>'col-sm-5')); ?>

		<?php echo $form->textFieldGroup($model,'modUserStamp',array('class'=>'col-sm-5','maxlength'=>50)); ?>

		<?php echo $form->textFieldGroup($model,'modTimeStamp',array('class'=>'col-sm-5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
