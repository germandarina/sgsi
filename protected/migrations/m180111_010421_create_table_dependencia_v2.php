<?php

class m180111_010421_create_table_dependencia_v2 extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `dependencia` (
                            `id` INT(11) NOT NULL AUTO_INCREMENT,
                            `activo_id` INT(11) NOT NULL,
                            `activo_padre_id` INT(11) NULL DEFAULT NULL,
                            `analisis_id` INT(11) NOT NULL,
                            `creaUserStamp` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_spanish2_ci',
                            `creaTimeStamp` TIMESTAMP NULL DEFAULT NULL,
                            `modUserStamp` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_spanish2_ci',
                            `modTimeStamp` TIMESTAMP NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            INDEX `activo_id` (`activo_id`),
                            INDEX `activo_padre_id` (`activo_padre_id`),
                            INDEX `analisis_id` (`analisis_id`),
                            CONSTRAINT `fk_dependencia_activo_id` FOREIGN KEY (`activo_id`) REFERENCES `activo` (`id`),
                            CONSTRAINT `fk_dependencia_activo_padre_id` FOREIGN KEY (`activo_padre_id`) REFERENCES `activo` (`id`),
                            CONSTRAINT `fk_dependencia_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`)
                        )
                        COLLATE='utf8_spanish2_ci'
                        ENGINE=InnoDB
                        ;");
	}

	public function down()
	{
		echo "m180111_010421_create_table_dependencia_v2 does not support migration down.\n";
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