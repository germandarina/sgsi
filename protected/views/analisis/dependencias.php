<script>
    $('document').ready(function () {
        inicializarTree();

    });
    function inicializarTree() {
        $.fn.extend({
            treed: function (o) {

                var openedClass = 'glyphicon-minus-sign';
                var closedClass = 'glyphicon-plus-sign';

                if (typeof o != 'undefined'){
                    if (typeof o.openedClass != 'undefined'){
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined'){
                        closedClass = o.closedClass;
                    }
                };

                /* initialize each of the top levels */
                var tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    var branch = $(this);
                    branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this == e.target) {
                            var icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children().children().toggle();
                        }
                    })
                    branch.children().children().toggle();
                });
                /* fire event from the dynamically added icon */
                tree.find('.branch .indicator').each(function(){
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });
                /* fire event to open branch if the li contains an anchor instead of text */
                tree.find('.branch>a').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
                /* fire event to open branch if the li contains a button instead of text */
                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });
        /* Initialization of treeviews */
        $('#tree1').treed();
    }

    function levantarModalDependencias() {
       limpiarYTraerDatosDependencia();
       $("#modalDependencias").modal('show');
    }


    function limpiarYTraerDatosDependencia() {
        $("#Dependencia_activo_id").select2('val',"");
        $("#Dependencia_activo_padre_id").select2('val',"");
        var analisis_id = $("#analisis_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/getPadresEHijos')?>",
            data: {'analisis_id': analisis_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var padres = datos.padres;
                var hijos = datos.hijos;

                if(padres.length >0){
                    $("#Dependencia_activo_padre_id").find('option').remove();
                    $("#Dependencia_activo_padre_id").select2('val', null);
                    $.each(padres, function (i, activo) {
                        $("#Dependencia_activo_padre_id").append('<option value="' + activo.id + '">' + activo.nombre + '</option>');
                    });
                }

                if(hijos.length >0){
                    $("#Dependencia_activo_id").find('option').remove();
                    $("#Dependencia_activo_id").select2('val', null);
                    $.each(hijos, function (i, activo) {
                        $("#Dependencia_activo_id").append('<option value="' + activo.id + '">' + activo.nombre + '</option>');
                    });
                }
            }
        });
    }
    function guardarDependencia() {
        var activo_padre_id = $("#Dependencia_activo_padre_id").val();
        var activo_id = $("#Dependencia_activo_id").val();
        var analisis_id = $("#analisis_id").val();
        if(activo_padre_id == activo_id){
            return Lobibox.notify('error',{msg: "El activo hijo no puede ser el mismo que el padre. Seleccione otro activo."})
        }

        Lobibox.confirm({
            title:'Confirmar',
            msg: "Esta seguro de realizar esta dependencia ?",
            callback: function (lobibox, type) {
                if (type === 'yes') {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo CController::createUrl('analisis/crearDependencia')?>",
                        data: { 'activo_padre_id': activo_padre_id,
                            'analisis_id':analisis_id,
                            'activo_id':activo_id
                        },
                        dataType: 'Text',
                        success: function (data) {
                            var datos = jQuery.parseJSON(data);
                            if(datos.error == 1){
                                Lobibox.notify('error',{msg: datos.msj});
                            }else{
                                Lobibox.notify('success',{msg: datos.msj});
                                limpiarYTraerDatosDependencia();
                                $("#divDependencias").empty().html(datos.html);
                                inicializarTree();
                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });




    }
</script>
<style>
    .tree, .tree ul {
        margin:0;
        padding:0;
        list-style:none
    }
    .tree ul {
        margin-left:1em;
        position:relative
    }
    .tree ul ul {
        margin-left:.5em
    }
    .tree ul:before {
        content:"";
        display:block;
        width:0;
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        border-left:1px solid
    }
    .tree li {
        margin:0;
        padding:0 1em;
        line-height:2em;
        color:#369;
        font-weight:700;
        position:relative
    }
    .tree ul li:before {
        content:"";
        display:block;
        width:10px;
        height:0;
        border-top:1px solid;
        margin-top:-1px;
        position:absolute;
        top:1em;
        left:0
    }
    .tree ul li:last-child:before {
        background:#fff;
        height:auto;
        top:1em;
        bottom:0
    }
    .indicator {
        margin-right:5px;
    }
    .tree li a {
        text-decoration: none;
        color:#369;
    }
    .tree li button, .tree li button:active, .tree li button:focus {
        text-decoration: none;
        color:#369;
        border:none;
        background:transparent;
        margin:0px 0px 0px 0px;
        padding:0px 0px 0px 0px;
        outline: 0;
    }
</style>
<div class="box-header">
    <?php $this->widget('booster.widgets.TbButton', array(
        'label'=> 'Dependencias ( + )',
        'context'=>'success',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:levantarModalDependencias()')
    ));
    ?>
</div>
<div class="box box-success" id="divDependencias">
    <?php if(!empty($dependenciasPadres)){?>
        <?php echo $this->renderPartial('dependenciasPadres', array('dependenciasPadres'=>$dependenciasPadres), true)?>
    <?php }?>
</div>

<div class="modal fade" id="modalDependencias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Nueva Dependencia</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <?php echo $this->renderPartial('_formDependencias', array('model' => $model, 'dependencia' => $dependencia,)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarDependencia()" class="btn btn-success" id="botonModal">
                    Agregar Dependencia
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>
