<?php

class m180213_184654_alter_table_actuaciones_add_accion extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE actuacion_riesgo  ADD COLUMN accion INT(4) DEFAULT NULL ");
	}

	public function down()
	{
		echo "m180213_184654_alter_table_actuaciones_add_accion does not support migration down.\n";
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