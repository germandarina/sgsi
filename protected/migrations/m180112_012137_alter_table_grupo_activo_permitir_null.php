<?php

class m180112_012137_alter_table_grupo_activo_permitir_null extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `grupo_activo`
                        ALTER `grupo_id` DROP DEFAULT;
                        ALTER TABLE `grupo_activo`
                        CHANGE COLUMN `grupo_id` `grupo_id` INT(11) NULL AFTER `activo_id`;");
	}

	public function down()
	{
		echo "m180112_012137_alter_table_grupo_activo_permitir_null does not support migration down.\n";
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