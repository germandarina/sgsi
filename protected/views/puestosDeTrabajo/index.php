<?php
$this->breadcrumbs=array(
	'Puestos De Trabajos',
);

$this->menu=array(
array('label'=>'Create PuestosDeTrabajo','url'=>array('create')),
array('label'=>'Manage PuestosDeTrabajo','url'=>array('admin')),
);
?>

<h1>Puestos De Trabajos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
