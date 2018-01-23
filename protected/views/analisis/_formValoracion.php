<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
        'id'=>'control-valor-form',
        'enableAjaxValidation'=>false,
        'type' => 'horizontal'
    )); ?>

    <input type="hidden" name="analisis_id" id="analisis_id" value="<?= $analisis->id?>">
    <input type="hidden" name="grupo_activo_id_hidden" id="grupo_activo_id_hidden" value="<?= isset($grupo_activo)? $grupo_activo->id : "" ?>">
    <input type="hidden" name="control_id" id="control_id">
    <input type="hidden" name="amenaza_id" id="amenaza_id">
    <input type="hidden" name="activo_id_hidden" id="activo_id_hidden">
    <input type="hidden" name="analisis_amenaza_id" id="analisis_amenaza_id" value="<?= isset($analisis_amenaza)?$analisis_amenaza->id :"" ?>">


    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->select2Group(
                $analisis, 'valor_form_valoracion',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => GrupoActivo::$arrayValores,
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
    <?php $this->endWidget(); ?>
</div>
