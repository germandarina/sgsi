<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'proyecto-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'col-sm-5','maxlength'=>50)); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model,'descripcion',array('class'=>'col-sm-5','maxlength'=>200)); ?>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->datepickerGroup($model, 'fecha', [
                'widgetOptions' => [
                    'options' => ['language' => 'es',
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        'startDate' => ($model->fecha),
                        'endDate' => ($model->fecha),
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
            <?php echo $form->select2Group(
                $model, 'areas',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Area::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['multiple'=>'multiple'],
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

        <?php $this->widget('booster.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => 'Volver',
            'size' => 'small',
            'buttonType' => 'link',
            'url' => $this->createUrl("admin"),
        )); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>