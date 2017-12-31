<?php
$this->breadcrumbs=array(
	'Amenazas',
);

$this->menu=array(
array('label'=>'Create Amenaza','url'=>array('create')),
array('label'=>'Manage Amenaza','url'=>array('admin')),
);
?>

<h1>Amenazas</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
