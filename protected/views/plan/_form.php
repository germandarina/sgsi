<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'id'=>'plan-form',
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
            <?php echo $form->datepickerGroup($model, 'fecha', [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        //'startDate' => ($model->fecha),
                        //'endDate' => ($model->fecha),
                    ],
                    'htmlOptions' => ['readonly' => 'readonly']
                ],
                'wrapperHtmlOptions' => ['class' => 'col-sm-9 input-group-sm'],
                'prepend' => '<i class="fa fa-calendar"></i>'
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5')); ?>
        </div>
    </div>

    <?php if(!$model->isNewRecord){?>

        <?php $plan_detalle = new PlanDetalle();
              $plan_detalle->plan_id = $model->id;
            echo $this->renderPartial('/planDetalle/admin',['model'=>$plan_detalle],'true')?>
    <?php }?>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'size'=>'small'
		)); ?>

        <?php $this->widget('booster.widgets.TbButton', array(
            'label' => 'Volver',
            'size' => 'small',
            'buttonType' => 'link',
            'url' => $this->createUrl("/analisis/admin"),
        )); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>