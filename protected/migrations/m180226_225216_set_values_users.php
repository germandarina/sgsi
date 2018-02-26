<?php

class m180226_225216_set_values_users extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE usuario CHANGE COLUMN `estado` `estado` INT(2) NULL DEFAULT '1'");
        $this->execute("UPDATE usuario set estado = 1");
	}

	public function down()
	{
		echo "m180226_225216_set_values_users does not support migration down.\n";
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