<?php
$this->breadcrumbs=array(
	'Procesos',
);

$this->menu=array(
array('label'=>'Create Proceso','url'=>array('create')),
array('label'=>'Manage Proceso','url'=>array('admin')),
);
?>

<h1>Procesos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
