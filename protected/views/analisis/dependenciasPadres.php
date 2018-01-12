<ul  id="tree1">
        <?php foreach ($dependenciasPadres as $dependenciaPadre){?>
                <li><?= $dependenciaPadre->activo->nombre ?>
                        <?php $hijos = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>$dependenciaPadre->activo_id));
                        if(count($hijos)){?>
                                <?php echo $this->renderPartial('dependenciasHijas', array('hijos'=>$hijos), true)?>
                        <?php }?>
                </li>
        <?php }?>
</ul>