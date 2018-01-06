<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('criterio')); ?>:</b>
	<?php echo CHtml::encode($data->criterio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_activo_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_activo_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creaUserStamp')); ?>:</b>
	<?php echo CHtml::encode($data->creaUserStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creaTimeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->creaTimeStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modUserStamp')); ?>:</b>
	<?php echo CHtml::encode($data->modUserStamp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('modTimeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->modTimeStamp); ?>
	<br />

	*/ ?>

</div>