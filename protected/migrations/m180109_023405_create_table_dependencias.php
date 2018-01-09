<?php

class m180109_023405_create_table_dependencias extends CDbMigration
{
	public function up()
	{
            $this->execute("CREATE TABLE `dependencia` (
                                `id` INT NOT NULL AUTO_INCREMENT,
                                `activo_padre_id` INT NOT NULL,
                                `activo_hijo_id` INT NOT NULL,
                                `analisis_id` INT NOT NULL,
                                `creaUserStamp` VARCHAR(50) NULL,
                                `creaTimeStamp` TIMESTAMP NULL,
                                `modUserStamp` VARCHAR(50) NULL,
                                `modTimeStamp` TIMESTAMP NULL,
                                PRIMARY KEY (`id`),
                                INDEX `activo_padre_id` (`activo_padre_id`),
                                INDEX `activo_hijo_id` (`activo_hijo_id`),
                                CONSTRAINT `fk_dependencias_activo_padre_id` FOREIGN KEY (`activo_padre_id`) REFERENCES `activo` (`id`),
                                CONSTRAINT `fk_dependencias_activo_hijo_id` FOREIGN KEY (`activo_hijo_id`) REFERENCES `activo` (`id`)
                            )
                            COLLATE='utf8_spanish2_ci'
                            ENGINE=InnoDB
                            ;

    ");
	}

	public function down()
	{
		echo "m180109_023405_create_table_dependencias does not support migration down.\n";
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