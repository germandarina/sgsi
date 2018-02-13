<?php

class m180213_135215_alter_tables_change_nombre_value extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `activo` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `amenaza` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `analisis` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `area` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `control` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `grupo` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `proceso` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `proyecto` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
        $this->execute("ALTER TABLE `vulnerabilidad` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL COLLATE 'utf8_spanish2_ci'; ");
    }

	public function down()
	{
		echo "m180213_135215_alter_tables_change_nombre_value does not support migration down.\n";
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