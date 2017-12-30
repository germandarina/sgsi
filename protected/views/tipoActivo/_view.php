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

	<b><?php echo CHtml::encode($data->getAttributeLabel('confidencialidad')); ?>:</b>
	<?php echo CHtml::encode($data->confidencialidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('integridad')); ?>:</b>
	<?php echo CHtml::encode($data->integridad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disponibilidad')); ?>:</b>
	<?php echo CHtml::encode($data->disponibilidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trazabilidad')); ?>:</b>
	<?php echo CHtml::encode($data->trazabilidad); ?>
	<br />


</div>