<?php

class m180107_022140_create_table_log_grupo_activo_valor extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `grupo_activo_log` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `grupo_activo_id` INT NULL,
                        `valor_anterior` INT NULL,
                        `valor_nuevo` INT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `grupo_activo_id` (`grupo_activo_id`),
                        CONSTRAINT `fk_grupo_activo_log_grupo_id` FOREIGN KEY (`grupo_activo_id`) REFERENCES `grupo_activo` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;");
	}

	public function down()
	{
		echo "m180107_022140_create_table_log_grupo_activo_valor does not support migration down.\n";
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