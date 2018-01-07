<?php

class m180106_194405_alter_table_grupo_activo extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `grupo_activo`
                            ADD COLUMN `valor` INT(4) NOT NULL AFTER `trazabilidad`;
                        ");
	}

	public function down()
	{
		echo "m180106_194405_alter_table_grupo_activo does not support migration down.\n";
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