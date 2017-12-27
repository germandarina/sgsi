
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'username',
		'creaUserStamp',
		'creaTimeStamp',

),
)); ?>
<br><br>
<?php $this->widget('booster.widgets.TbButton', array(
	//'buttonType'=>'submit',
	'label' => 'Volver',
	'size' => 'small',
	'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
)); ?>