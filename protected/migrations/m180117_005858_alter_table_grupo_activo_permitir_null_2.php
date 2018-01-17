<?php

class m180117_005858_alter_table_grupo_activo_permitir_null_2 extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `grupo_activo`
                        ALTER `confidencialidad` DROP DEFAULT,
                        ALTER `integridad` DROP DEFAULT,
                        ALTER `disponibilidad` DROP DEFAULT,
                        ALTER `trazabilidad` DROP DEFAULT; ");

        $this->execute(" ALTER TABLE `grupo_activo`
                        CHANGE COLUMN `confidencialidad` `confidencialidad` INT(4) NULL AFTER `analisis_id`,
                        CHANGE COLUMN `integridad` `integridad` INT(4) NULL AFTER `confidencialidad`,
                        CHANGE COLUMN `disponibilidad` `disponibilidad` INT(4) NULL AFTER `integridad`,
                        CHANGE COLUMN `trazabilidad` `trazabilidad` INT(4) NULL AFTER `disponibilidad`;");
	}

	public function down()
	{
		echo "m180117_005858_alter_table_grupo_activo_permitir_null does not support migration down.\n";
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