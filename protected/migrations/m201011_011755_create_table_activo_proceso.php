<?php

class m201011_011755_create_table_activo_proceso extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `activo_area_proceso` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `activo_area_id` INT NOT NULL,
                        `proceso_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `activo_area_id` (`activo_area_id`),
                        INDEX `proceso_id` (`proceso_id`),
                        CONSTRAINT `activo_area_proceso_activo_area_id` FOREIGN KEY (`activo_area_id`) REFERENCES `activo_area` (`id`),
                        CONSTRAINT `activo_area_proceso_proceso_id` FOREIGN KEY (`proceso_id`) REFERENCES `proceso` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");

	}

	public function down()
	{
		$this->execute("drop table activo_proceso");
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