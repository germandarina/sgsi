<?php

class m180324_012303_create_table_plan_detalle extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `plan_detalle` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `plan_id` INT NULL,
                            `analisis_control_id` INT NULL,
                            `fecha_posible_inicio` DATE NULL,
                            `fecha_posible_fin` DATE NULL,
                            `fecha_real_inicio` DATE NULL,
                            `fecha_real_fin` DATE NULL,
                            `creaUserStamp` VARCHAR(50) NULL,
                            `creaTimeStamp` TIMESTAMP NULL,
                            `modUserStamp` VARCHAR(50) NULL,
                            `modTimeStamp` TIMESTAMP NULL,
                            PRIMARY KEY (`id`),
                            INDEX `plan_id` (`plan_id`),
                            INDEX `analisis_control_id` (`analisis_control_id`),
                            CONSTRAINT `plan_detalle_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`),
                            CONSTRAINT `plan_detalle_analisis_control_id` FOREIGN KEY (`analisis_control_id`) REFERENCES `analisis_control` (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;
");
	}

	public function down()
	{
		echo "m180324_012303_create_table_plan_detalle does not support migration down.\n";
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