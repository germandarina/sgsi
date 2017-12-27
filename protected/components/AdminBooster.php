<?php

class AdminBooster extends Booster {
    protected function appendUserSuppliedPackagesToOurs() {

        $bootstrapPackages = require(Yii::getPathOfAlias('application.config') . '/packages.php');
        $bootstrapPackages += $this->createBootstrapCssPackage();
        $bootstrapPackages += $this->createSelect2Package();

        $this->packages = CMap::mergeArray(
            $bootstrapPackages,
            $this->packages
        );
    }
}