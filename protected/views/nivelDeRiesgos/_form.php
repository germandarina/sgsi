<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'id'=>'nivel-de-riesgos-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
     <div class="row">
            <div class="col-sm-6">
                <?php echo $form->numberFieldGroup($model,'valor_minimo',array('class'=>'col-sm-5')); ?>

            </div>
     </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->numberFieldGroup($model,'valor_maximo',array('class'=>'col-sm-5')); ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'concepto',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => NivelDeRiesgos::$arrayConceptos,
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
//                        'htmlOptions' => ['onChange'=>'getActivos()'],
                    ],
                ]
            );
            ?>

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