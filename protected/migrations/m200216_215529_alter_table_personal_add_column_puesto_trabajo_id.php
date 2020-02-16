<?php

class m200216_215529_alter_table_personal_add_column_puesto_trabajo_id extends CDbMigration
{
	public function up()
	{
	    $this->execute("ALTER TABLE personal ADD COLUMN puesto_trabajo_id int(11) default null");
	}

	public function down()
	{
		echo "m200216_215529_alter_table_personal_add_column_puesto_trabajo_id does not support migration down.\n";
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