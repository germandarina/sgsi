<?php

class m180106_034836_create_table_activo extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `activo` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
                        `tipo_activo_id` INT NOT NULL,
                        `personal_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `tipo_activo_id` (`tipo_activo_id`),
                        INDEX `personal_id` (`personal_id`),
                        CONSTRAINT `fk_activo_tipo_activo_id` FOREIGN KEY (`tipo_activo_id`) REFERENCES `tipo_activo` (`id`),
                        CONSTRAINT `fk_activo_personal_id` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m180106_034836_create_table_activo does not support migration down.\n";
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