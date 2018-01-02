<?php

class m180101_234820_create_table_vulnerabilidad extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `vulnerabilidad` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
                        `amenaza_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `amenaza_id` (`amenaza_id`),
                        CONSTRAINT `fk_vulnerabilidad_amenaza_id` FOREIGN KEY (`amenaza_id`) REFERENCES `amenaza` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m180101_234820_create_table_vulnerabilidad does not support migration down.\n";
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