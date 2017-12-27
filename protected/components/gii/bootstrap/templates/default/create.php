<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('$label' => array('admin'), 'Crear'),
	)
);\n ?>";
?>

<div class="box">

	<div class="box-header with-border">
		<h3>Crear <?php echo $this->modelClass; ?></h3>
	</div>

	<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

</div>