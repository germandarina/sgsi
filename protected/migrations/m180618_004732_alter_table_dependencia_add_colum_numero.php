<?php

class m180618_004732_alter_table_dependencia_add_colum_numero extends CDbMigration
{
	public function up()
	{
	    $this->execute("alter table dependencia add column numero int(11) default null");
	}

	public function down()
	{
		echo "m180618_004732_alter_table_dependencia_add_colum_numero does not support migration down.\n";
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