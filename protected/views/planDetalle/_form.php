<div class="box-body">
    <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
	'id'=>'plan-detalle-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

    <input type="hidden" name="plan_detalle_id" id="plan_detalle_id" >

    <div class="col-sm-12">

        <div class="form-group">
            <label class="col-sm-3 control-label" for="PlanDetalle_fecha_posible_inicio">Fecha Posible Inicio</label>
            <div class="col-sm-9 input-group-sm col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control ct-form-control" type="date" autocomplete="off" placeholder="Fecha Posible Inicio" name="PlanDetalle[fecha_posible_inicio]" id="PlanDetalle_fecha_posible_inicio">
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="PlanDetalle_fecha_posible_inicio">Fecha Posible Inicio</label>
            <div class="col-sm-9 input-group-sm col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control ct-form-control" type="date" autocomplete="off" placeholder="Fecha Posible Fin" name="PlanDetalle[fecha_posible_fin]" id="PlanDetalle_fecha_posible_fin">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="PlanDetalle_fecha_posible_inicio">Fecha Real Inicio</label>
            <div class="col-sm-9 input-group-sm col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control ct-form-control" type="date" autocomplete="off" placeholder="Fecha Real Inicio" name="PlanDetalle[fecha_real_inicio]" id="PlanDetalle_fecha_real_inicio">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="PlanDetalle_fecha_real_inicio">Fecha Real Inicio</label>
            <div class="col-sm-9 input-group-sm col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control ct-form-control" type="date" autocomplete="off" placeholder="Fecha Real Inicio" name="PlanDetalle[fecha_real_fin]" id="PlanDetalle_fecha_real_fin">
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>