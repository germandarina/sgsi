<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
        'id'=>'control-valor-form',
        'enableAjaxValidation'=>false,
        'type' => 'horizontal'
    )); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($grupo_activo); ?>

    <input type="hidden" name="analisis_id" id="analisis_id" value="<?= $model->id ?>">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $grupo_activo, 'grupo_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Grupo::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onChange'=>'getActivos()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $grupo_activo, 'activo_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Activo::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                       // 'htmlOptions' => ['multiple'=>'multiple'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->numberFieldGroup($grupo_activo,'confidencialidad',array('class'=>'col-sm-3')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->numberFieldGroup($grupo_activo,'integridad',array('class'=>'col-sm-3')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->numberFieldGroup($grupo_activo,'disponibilidad',array('class'=>'col-sm-3')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->numberFieldGroup($grupo_activo,'trazabilidad',array('class'=>'col-sm-3')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>