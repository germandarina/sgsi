<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'id'=>'puestos-de-trabajo-form',
	'type' => 'horizontal',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'area_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Area::model()->getAreasDisponiblesPorProyecto(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onChange'=>'getProcesos()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>255)); ?>
        </div>
    </div>


    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'size'=>'small'
		)); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'label'=> 'Cancelar',
			'size' => 'small',
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>