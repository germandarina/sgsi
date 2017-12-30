<?php
$this->breadcrumbs=array(
	'Organizacions',
);

$this->menu=array(
array('label'=>'Create Organizacion','url'=>array('create')),
array('label'=>'Manage Organizacion','url'=>array('admin')),
);
?>

<h1>Organizacions</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
