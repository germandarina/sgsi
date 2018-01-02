<?php
$this->breadcrumbs=array(
	'Controls',
);

$this->menu=array(
array('label'=>'Create Control','url'=>array('create')),
array('label'=>'Manage Control','url'=>array('admin')),
);
?>

<h1>Controls</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
