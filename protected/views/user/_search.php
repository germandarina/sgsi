<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

		<?php echo $form->textFieldGroup($model,'username',array('class'=>'col-sm-5','maxlength'=>50)); ?>

			<?php echo $form->textFieldGroup($model,'sucursalId',array('class'=>'col-sm-5')); ?>

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
