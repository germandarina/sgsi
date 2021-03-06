<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>


<div class="box">
	<div class="box-header">
		<h3 class="box-title">Admin <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h3>
		<?php
		echo "<?php \$this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('".$this->modelClass."/create')),
						)
					),
				),
			)
		); ?>"
		?>
	</div>

	<?php echo "<?php"; ?> $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	'type' => 'striped hover condensed',
	'dataProvider' => $model->search(),
	'responsiveTable' => true,
	'template' => "{summary}\n{items}\n{pager}",
	'selectableRows' => 1,
	'filter' => $model,
	'columns'=>array(
	<?php
	$count = 0;
	foreach ($this->tableSchema->columns as $column) {
		if (++$count == 7) {
			echo "\t\t/*\n";
		}
		echo "\t\t'" . $column->name . "',\n";
	}
	if ($count >= 7) {
		echo "\t\t*/\n";
	}
	?>
	array(
	'class'=>'booster.widgets.TbButtonColumn',
	),
	),
	)); ?>
</div>



