<ul  id="tree1">
        <?php foreach ($dependenciasPadres as $dependenciaPadre){?>
                <li><?= $dependenciaPadre->activo->nombre ?>
                        <?php $hijos = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>$dependenciaPadre->activo_id,
                                                                                        'numero'=>$dependenciaPadre->numero,
                                                                                        'analisis_id'=>$dependenciaPadre->analisis_id));
                        if(!empty($hijos)){?>
                                <?php echo $this->renderPartial('dependenciasHijas', array('hijos'=>$hijos), true)?>
                        <?php }?>
                </li>
        <?php }?>
</ul>