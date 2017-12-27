<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="box-body">
    <?php echo "<?php \$form=\$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>\n"; ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

    <?php
    foreach ($this->tableSchema->columns as $column) {
        if ($column->autoIncrement || in_array($column->name, ['timeStamp', 'userStamp'])) {
            continue;
        }
        ?>
        <?php echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?>\n"; ?>
    <?php } ?>

    <div class="box-footer">
        <?php echo "<?php \$this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>\$model->isNewRecord ? 'Crear' : 'Guardar',
			'size'=>'small'
		)); ?>\n"; ?>

        <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'label'=> 'Cancelar',
			'size' => 'small',
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>\n" ?>
    </div>
    <?php echo "<?php \$this->endWidget(); ?>\n" ?>

</div>