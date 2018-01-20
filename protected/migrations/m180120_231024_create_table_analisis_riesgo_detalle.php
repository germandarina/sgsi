<?php

class m180120_231024_create_table_analisis_riesgo_detalle extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `analisis_riesgo_detalle` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `analisis_riesgo_id` INT NULL,
                            `grupo_activo_id` INT NULL,
                            `valor_activo` INT NULL,
                            `valor_integridad` INT NULL,
                            `valor_disponibilidad` INT NULL,
                            `valor_confidencialidad` INT NULL,
                            `valor_trazabilidad` INT NULL,
                            `creaUserStamp` VARCHAR(50) NULL,
                            `creaTimeStamp` TIMESTAMP NULL,
                            `modUserStamp` VARCHAR(50) NULL,
                            `modTimeStamp` TIMESTAMP NULL,
                            PRIMARY KEY (`id`),
                            INDEX `analisis_riesgo_id` (`analisis_riesgo_id`),
                            INDEX `grupo_activo_id` (`grupo_activo_id`),
                            CONSTRAINT `fk_analisis_riesgo_detalle_analisis_riesgo_id` FOREIGN KEY (`analisis_riesgo_id`) REFERENCES `analisis_riesgo` (`id`),
                            CONSTRAINT `fk_analisis_riesgo_detalle_grupo_activo_id` FOREIGN KEY (`grupo_activo_id`) REFERENCES `grupo_activo` (`id`)
                        )
                        COLLATE='utf8_spanish2_ci'
                        ENGINE=InnoDB
                        ;
                        ");
	}

	public function down()
	{
		echo "m180120_231024_create_table_analisis_riesgo_detalle does not support migration down.\n";
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