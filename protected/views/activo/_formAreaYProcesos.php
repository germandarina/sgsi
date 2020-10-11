<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
        'id'=>'control-valor-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'type' => 'horizontal'
    )); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

    <input type="hidden" name="activo_id" id="activo_id" value="<?= $model->activo_id ?>">
    <div class="row">
        <div class="col-sm-12">
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
                        'htmlOptions' => ['onChange'=>'getProcesosPorArea()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $model, 'procesos',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => [],
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