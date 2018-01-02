<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amenaza_id')); ?>:</b>
	<?php echo CHtml::encode($data->amenaza_id); ?>
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