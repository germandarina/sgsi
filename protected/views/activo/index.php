<?php
$this->breadcrumbs=array(
	'Activos',
);

$this->menu=array(
array('label'=>'Create Activo','url'=>array('create')),
array('label'=>'Manage Activo','url'=>array('admin')),
);
?>

<h1>Activos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
