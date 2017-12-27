<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'padreId'); ?>
		<?php echo $form->textField($model,'padreId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'titulo'); ?>
		<?php echo $form->textField($model,'titulo',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sucursalId'); ?>
		<?php echo $form->textField($model,'sucursalId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visible'); ?>
		<?php echo $form->textField($model,'visible'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orden'); ?>
		<?php echo $form->textField($model,'orden'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->