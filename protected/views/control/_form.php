<script>
    function levantarModal() {
        $("#modalFormDetalle").modal("show");
    }
</script>
<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'control-form',
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
            <?php echo $form->textFieldGroup($model,'numeracion',array('class'=>'col-sm-5','maxlength'=>50)); ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
                <?php echo $form->labelEx($model,'descripcion',array('class'=>'col-sm-3')); ?>
                <?php echo $form->textArea($model,'descripcion',array('class'=>'col-sm-9','rows'=>6, 'cols'=>75)); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'vulnerabilidad_id',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => CHtml::listData(Vulnerabilidad::model()->findAll(), 'id', 'nombre'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
//                        'htmlOptions' => ['onChange'=>'getProcesos()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <div class="panel box box-solid box-success">
        <div class="box-header with-border">
            <h4 class="box-title">
                Valores Control
            </h4>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="box-header with-border">
                <?php if(!$model->isNewRecord) {
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'Agregar Valor ( + )',
                        'context' => 'primary',
                        'size' => 'small',
                        'id' => "botonModal",
                        'htmlOptions' => array('onclick' => 'js:levantarModal()', 'class' => "btn btn-success"),
                    ));

                    $this->widget('booster.widgets.TbExtendedGridView', array(
                        'id' => 'control-grid',
                        'fixedHeader' => false,
                        'headerOffset' => 10,
                        // 40px is the height of the main navigation at bootstrap
                        'type' => 'striped hover condensed',
                        'dataProvider' => $controlValor->search(),
                        'responsiveTable' => true,
                        'template' => "{summary}\n{items}\n{pager}",
                        'selectableRows' => 1,
                        //'filter' => $model,
                        'columns' => array(
                            'fecha',
                            'valor',
                            'creaUserStamp',
                            'creaTimeStamp',
                            array(
                                'class' => 'booster.widgets.TbButtonColumn',
                                'template' => '{update}{delete}'
                            ),
                        ),
                    ));
                } ?>
            </div>
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
<div class="modal fade" id="modalFormDetalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Nuevo Valor</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <?php echo $this->renderPartial('/controlValor/_form', array('model' => $model, 'controlValor' => $controlValor,)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarValores()" class="btn btn-success" id="botonModal">
                    Agregar Detalle
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>