<?php
$this->breadcrumbs=array(
	'Tipo Activos',
);

$this->menu=array(
array('label'=>'Create TipoActivo','url'=>array('create')),
array('label'=>'Manage TipoActivo','url'=>array('admin')),
);
?>

<h1>Tipo Activos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
