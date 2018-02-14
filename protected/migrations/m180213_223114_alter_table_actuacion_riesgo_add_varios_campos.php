<?php

class m180213_223114_alter_table_actuacion_riesgo_add_varios_campos extends CDbMigration
{
	public function up()
	{
        $this->execute("alter table actuacion_riesgo add column accion_transferir int(4) DEFAULT null");
    }

	public function down()
	{
		echo "m180213_223114_alter_table_actuacion_riesgo_add_varios_campos does not support migration down.\n";
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