<?php

class m180124_005923_create_table_actuacion_riesgo extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `actuacion_riesgo` (
                            `id` INT(11) NOT NULL AUTO_INCREMENT,
                            `analisis_riesgo_detalle_id` INT(11) NOT NULL,
                            `fecha` DATE NOT NULL,
                            `descripcion` VARCHAR(200) NOT NULL,
                            `creaUserStamp` VARCHAR(50) NULL,
                            `creaTimeStamp` TIMESTAMP NULL,
                            `modUserStamp` VARCHAR(50) NULL,
                            `modTimeStamp` TIMESTAMP NULL,
                            PRIMARY KEY (`id`),
                            INDEX `analisis_riesgo_detalle_id` (`analisis_riesgo_detalle_id`),
                            CONSTRAINT `fk_actuacion_riesgo_analisis_riesgo_detalle_id` FOREIGN KEY (`analisis_riesgo_detalle_id`) REFERENCES `analisis_riesgo_detalle` (`id`)
                        )
                        COLLATE='utf8_spanish2_ci'
                        ENGINE=InnoDB
                        ;
                        ");
	}

	public function down()
	{
		echo "m180124_005923_create_table_actuacion_riesgo does not support migration down.\n";
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