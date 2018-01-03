<?php

class m180103_021345_create_table_control_valor extends CDbMigration
{
	public function up()
	{
                    $this->execute("CREATE TABLE `control_valor` (
                                    `id` INT NOT NULL AUTO_INCREMENT,
                                    `fecha` DATE NULL,
                                    `valor` INT NULL,
                                    `control_id` INT NULL,
                                    `creaUserStamp` VARCHAR(50) NULL,
                                    `creaTimeStamp` TIMESTAMP NULL,
                                    `modUserStamp` VARCHAR(50) NULL,
                                    `modTimeStamp` TIMESTAMP NULL,
                                    PRIMARY KEY (`id`),
                                    INDEX `control_id` (`control_id`),
                                    CONSTRAINT `fk_control_valor_control_id` FOREIGN KEY (`id`) REFERENCES `control` (`id`)
                                )
                                COLLATE='utf8_spanish2_ci'
                                ENGINE=InnoDB
                                ;");
	}

	public function down()
	{
		echo "m180103_021345_create_table_control_valor does not support migration down.\n";
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