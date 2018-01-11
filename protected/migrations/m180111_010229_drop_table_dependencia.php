<?php

class m180111_010229_drop_table_dependencia extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE dependencia");
	}

	public function down()
	{
		echo "m180111_010229_drop_table_dependencia does not support migration down.\n";
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