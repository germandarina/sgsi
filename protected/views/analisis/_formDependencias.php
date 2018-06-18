<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
        'id'=>'control-valor-form',
        'enableAjaxValidation'=>false,
        'type' => 'horizontal'
    )); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($dependencia); ?>

    <input type="hidden" name="analisis_id" id="analisis_id" value="<?= $model->id ?>">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $dependencia, 'activo_padre_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => [],//CHtml::listData(Activo::model()->getPadresDisponibles($model->id,$model->proyecto_id), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
                        'htmlOptions' => ['onchange'=>'tieneMultiplesPadres()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row" id="divActivoRamaId" style="display: none;">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $dependencia, 'activo_rama_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => [],//CHtml::listData(Activo::model()->getPadresDisponibles($model->id,$model->proyecto_id), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
//                        'htmlOptions' => ['onchange'=>'tieneMultiplesPadres()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $dependencia, 'activo_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => [],//CHtml::listData(Activo::model()->getHijosDisponibles($model->id,$model->proyecto_id), 'id', 'nombre'),
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
    <?php $this->endWidget(); ?>

</div>