<?php

class m180121_003314_alter_table_analisis_riesgo_detalle_add_column_nivel_riesgo_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `analisis_riesgo_detalle`
                            ADD COLUMN `nivel_riesgo_id` INT(11) NULL DEFAULT NULL AFTER `valor_trazabilidad`,
                            ADD INDEX `nivel_riesgo_id` (`nivel_riesgo_id`),
                            ADD CONSTRAINT `fk_analisis_riesgo_detalle_nivel_riesgo_id` FOREIGN KEY (`nivel_riesgo_id`) REFERENCES `nivel_de_riesgos` (`id`);
                        ");
	}

	public function down()
	{
		echo "m180121_003314_alter_table_analisis_riesgo_detalle_add_column_nivel_riesgo_id does not support migration down.\n";
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