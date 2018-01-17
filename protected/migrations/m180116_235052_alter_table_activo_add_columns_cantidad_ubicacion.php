<?php

class m180116_235052_alter_table_activo_add_columns_cantidad_ubicacion extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE activo ADD COLUMN cantidad INT(11) DEFAULT NULL");
        $this->execute("ALTER TABLE activo ADD COLUMN ubicacion VARCHAR(100) DEFAULT NULL");
	}

	public function down()
	{
		echo "m180116_235052_alter_table_activo_add_columns_cantidad_ubicacion does not support migration down.\n";
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