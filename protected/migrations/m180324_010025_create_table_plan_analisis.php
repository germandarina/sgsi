<?php

class m180324_010025_create_table_plan_analisis extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `plan` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `analisis_id` INT NOT NULL,
                            `fecha` DATE NOT NULL,
                            `nombre` VARCHAR(50) NOT NULL,
                            `creaUserStamp` VARCHAR(50) NULL,
                            `creaTimeStamp` TIMESTAMP NULL,
                            `modUserStamp` VARCHAR(50) NULL,
                            `modTimeStamp` TIMESTAMP NULL,
                            PRIMARY KEY (`id`),
                            INDEX `analisis_id` (`analisis_id`),
                            CONSTRAINT `plan_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`)
                        )
                        COLLATE='utf8_spanish_ci'
                        ENGINE=InnoDB
                        ;");
	}

	public function down()
	{
		echo "m180324_010025_create_table_plan_analisis does not support migration down.\n";
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