<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('padreId')); ?>:</b>
	<?php echo CHtml::encode($data->padreId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label')); ?>:</b>
	<?php echo CHtml::encode($data->label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('titulo')); ?>:</b>
	<?php echo CHtml::encode($data->titulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sucursalId')); ?>:</b>
	<?php echo CHtml::encode($data->sucursalId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visible')); ?>:</b>
	<?php echo CHtml::encode($data->visible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orden')); ?>:</b>
	<?php echo CHtml::encode($data->orden); ?>
	<br />

	*/ ?>

</div>