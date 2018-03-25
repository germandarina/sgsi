<?php

class m180324_013217_alter_table_varias extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `activo` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `amenaza` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `analisis` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `area` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `control` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `grupo` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `proceso` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `proyecto` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `vulnerabilidad` CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NOT NULL COLLATE 'utf8_spanish2_ci'; ");


        $this->execute("ALTER TABLE `activo` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `amenaza` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `analisis` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `area` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `control` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `grupo` CHANGE COLUMN `criterio` `criterio` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `proceso` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `proyecto` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `vulnerabilidad` CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL COLLATE 'utf8_spanish2_ci'; ");
	}

	public function down()
	{
		echo "m180324_013217_alter_table_varias does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}